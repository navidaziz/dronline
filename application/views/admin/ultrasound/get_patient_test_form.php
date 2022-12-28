<div class="row">
  <div class="col-md-4">
    <h3>Patient Detail</h3>
    <table class="table table-bordered" style="text-align: left;">
      <tr>
        <th style="width: 30%;">Invoice No:</th>
        <td><?php echo $invoice_detail->invoice_id; ?></td>
      </tr>

      <tr>
        <th>Patient Name: </th>
        <td><?php echo $invoice_detail->patient_name; ?></td>
      </tr>
      <tr>
        <th>Gender:</th>
        <td><?php echo $invoice_detail->patient_gender; ?></td>
      </tr>
      <tr>
        <th>Mobile No:</th>
        <td><?php echo $invoice_detail->patient_mobile_no; ?></td>
      </tr>
      <tr>
        <th>Address</th>
        <td><?php echo $invoice_detail->patient_address; ?></td>
      </tr>
      <tr>
        <th>Refered By:</th>
        <td><?php echo $invoice_detail->doctor_name . "( " . $invoice_detail->doctor_designation . " )"; ?></td>
      </tr>

      <tr>
        <th>Registered:</th>
        <td title="<?php
                    if ($invoice_detail->created_date) {
                      echo date("d M, Y h:i:s", strtotime($invoice_detail->created_date));
                    }
                    ?>"><?php echo get_timeago($invoice_detail->created_date); ?></td>
      </tr>

      <tr>
        <th>Received:</th>
        <td title="<?php
                    if ($invoice_detail->process_date) {
                      echo date("d M, Y h:i:s", strtotime($invoice_detail->process_date));
                    }
                    ?>"><?php
                        if ($invoice_detail->process_date) {
                          echo get_timeago($invoice_detail->process_date);
                        } ?></td>
      </tr>
      <tr>
        <th>Reported:</th>

        <td title="<?php
                    if ($invoice_detail->reported_date) {
                      echo date("d M, Y h:i:s", strtotime($invoice_detail->reported_date));
                    }
                    ?>">
          <?php
          if ($invoice_detail->reported_date) {
            echo get_timeago($invoice_detail->reported_date);
          } ?></td>
      </tr>


    </table>

    <h3>Invoice</h3>
    <table class="table table-bordered" style="text-align: left;">
      <tr>
        <th style="width: 30%;">#</th>
        <td>Test</td>
        <td>Total Rs</td>
      </tr>
      <?php
      $count = 1;
      foreach ($invoice->invoice_details as $invoice_detail) { ?>
        <tr>
          <th style="width: 30%;"><?php echo $count++; ?></th>
          <td><?php echo $invoice_detail->test_group_name; ?></td>
          <td><?php echo $invoice_detail->price; ?></td>
        </tr>
      <?php } ?>
      <tr>
        <th colspan="2" style="text-align: left;">Total</th>
        <td><?php echo $invoice->price; ?></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: left;">Discount</th>
        <td><?php echo $invoice->discount; ?></td>
      </tr>

      <tr>
        <th colspan="2" style="text-align: left;">Paid</th>
        <td><?php echo $invoice->total_price; ?></td>
      </tr>

    </table>

  </div>
  <div class="col-md-8">
    <form action="<?php echo site_url(ADMIN_DIR . "ultrasounds/complete_test"); ?>" method="post">
      <?php foreach ($patient_tests_groups as $patient_tests_group) { ?>
        <h3><?php echo $patient_tests_group->test_group_name; ?></h3>
        <table class="table table-bordered" style="text-align: left;">
          <tr>
            <th>#</th>
            <th>Test Name</th>
            <th>Test Result</th>
            <th>Unit</th>
            <th>Normal Value</th>
            <!-- <th>Remarks</th> -->
          </tr>
          <?php
          $count = 1;
          foreach ($patient_tests_group->patient_tests as $patient_test) { ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $patient_test->test_name; ?></td>
              <td><input class="test_value_input" onkeyup="update_test_value('<?php echo $patient_test->patient_test_id; ?>')" type="text" id="test_<?php echo $patient_test->patient_test_id; ?>_value" value="<?php echo $patient_test->test_result; ?>" name="test_values[<?php echo $patient_test->patient_test_id; ?>]" /></td>
              <td><?php echo $patient_test->unit; ?></td>
              <td><?php echo $patient_test->test_normal_value; ?></td>
              <!-- <td><input type="text" onkeyup="update_test_remarks('<?php echo $patient_test->patient_test_id; ?>')" id="test_<?php echo $patient_test->patient_test_id; ?>_remark" value="<?php echo $patient_test->remarks; ?>" /></td> -->
            </tr>
          <?php } ?>
        </table>
      <?php  } ?>


      <script src="//cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>

      <div style="text-align: left;"><strong>Ultrasound Report</strong>
        <textarea name="test_remarks" id="test_remarks" class="form-control" style="margin-bottom: 5px;"><?php echo $invoice->remarks; ?></textarea>
      </div>

      <script>
        CKEDITOR.replace('test_remarks');
        CKEDITOR.config.height = 400;
      </script>
      <br />
      <input type="hidden" value="<?php echo $invoice_id; ?>" name="invoice_id" />
      <input class="btn btn-success" type="submit" value="Complete Test" name="Complete and Save Ultrasound Report" />
    </form>
  </div>
</div>
<script>
  $('.test_value_input').keydown(function(e) {
    if (e.keyCode == 40 || e.keyCode == 13) {

      var index = $("input[type='text']").index(this);
      $("input[type='text']").eq(index + 1).focus();
      $("input[type='text']").eq(index + 1).select();
      e.preventDefault();

    }
    if (e.keyCode == 38) {
      var index = $("input[type='text']").index(this);
      $("input[type='text']").eq(index - 1).focus();
      e.preventDefault();

    }

    if (e.keyCode == 13) {
      var index = $("input[type='text']").index(this);
      $("input[type='text']").eq(index + 1).focus();
      e.preventDefault();
    }
  });

  function update_test_value(patient_test_id) {


    var partient_test_value = $('#test_' + patient_test_id + '_value').val();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR); ?>/update_test_value/",
      data: {
        patient_test_id: patient_test_id,
        partient_test_value: partient_test_value
      }
    }).done(function(data) {
      // alert(data);
      //console.log(data);
      // $('#patient_test').html(data);
    });
  }
  //partient_test_remark

  function update_test_remarks(patient_test_id) {


    var partient_test_remark = $('#test_' + patient_test_id + '_remark').val();
    //alert(partient_test_remark);
    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR); ?>/update_test_remark/",
      data: {
        patient_test_id: patient_test_id,
        partient_test_remark: partient_test_remark
      }
    }).done(function(data) {
      //alert(data);
      //console.log(data);
      // $('#patient_test').html(data);
    });
  }
</script>