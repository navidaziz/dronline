<div class="row">
  <div class="col-md-4">
    <h3>Patient Detail</h3>
    <table class="table table-bordered" style="text-align: left;">
      <tr>
        <th style="width: 30%;">Invoice No:</th>
        <td><?php echo $invoice_detail->invoice_id; ?></td>
      </tr>
      <tr>
        <th>Test Token No.</th>
        <td><?php echo $invoice_detail->test_token_id; ?></td>
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
      foreach ($invoice->invoice_details as $invoicedetail) { ?>
        <tr>
          <th style="width: 30%;"><?php echo $count++; ?></th>
          <td><?php echo $invoicedetail->test_group_name; ?></td>
          <td><?php echo $invoicedetail->price; ?></td>
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




    <?php foreach ($patient_tests_groups as $patient_tests_group) { ?>
      <h3><?php echo $patient_tests_group->test_group_name; ?></h3>
      <table class="table table-bordered" style="text-align: left;">
        <tr>
          <th>#</th>
          <th>Test Name</th>
          <th>Test Result</th>
          <th>Normal Value</th>
          <th>Remarks</th>
        </tr>
        <?php
        $count = 1;
        foreach ($patient_tests_group->patient_tests as $patient_test) { ?>
          <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $patient_test->test_name; ?></td>
            <td> <?php echo $patient_test->test_result; ?> <strong><?php echo $patient_test->result_suffix; ?></strong></td>
            <td><?php echo $patient_test->test_normal_value; ?></td>
            <td><?php echo $patient_test->remarks; ?> </td>
          </tr>
        <?php } ?>
      </table>
    <?php  } ?>
    <div style="text-align: left;"><strong>Remarks:</strong>
      <p style="border: 1px dashed #ddd; border-radius: 5px; padding: 5px; min-height: 50px;"><?php echo $invoice_detail->remarks; ?></p>
    </div>
    <a target="new" href="<?php echo site_url(ADMIN_DIR . "lab/print_patient_test_report/$invoice_id") ?>" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> Print Test Report</a>
  </div>
</div>