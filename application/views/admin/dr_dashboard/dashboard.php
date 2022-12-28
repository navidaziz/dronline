<!-- PAGE HEADER-->
<div class="row">
  <div class="col-sm-12">
    <div class="page-header" style="min-height: 10px;">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">


        <li>
          <i class="fa fa-table"></i> Today Online Appointment Dashboard
        </li>

      </ul>


    </div>
  </div>
</div>


<?php

//now we will check if the current module is assigned to the user or not
/*$this->data['current_action_id'] = $current_action_id = $this->module_m->actionIdFromName($this->controller_name, $this->method_name);*/
$this->data['current_action_id'] = $current_action_id = $this->module_m->allowed_module_id($this->controller_name);

$allowed_modules = $this->mr_m->rightsByRole($this->session->userdata("role_id"));

//var_dump($allowed_modules);
//add role homepage to allowed modules
$allowed_modules[] = $this->session->userdata("role_homepage_id");

if (!in_array($current_action_id, $allowed_modules)) { ?>

  <div style=" margin:0px auto; width:100%; text-align:center !important;">
    <div style="margin:150px !important;">

      <h1 style="color: #d9534f;  font-size: 80px;  ">Access Denied</h1>
      <div class="content">
        <h3>Oops! Something went wrong</h3>
        <p>You are not allowed to access this module. Thanks.</p>
        <div class="btn-group">
          <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>" class="btn btn-danger"><i class="fa fa-chevron-left"></i> Go Back</a>
        </div>
      </div>

    </div>

  </div>

<?php
  exit();
}

?>



<?php
$add_form_attr = array("class" => "form-horizontal");
echo form_open_multipart(ADMIN_DIR . "reception/save_data", $add_form_attr);
?>
<div class="row">
  <!-- MESSENGER -->


  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-forward"></i> Today New Appointments</h4>
      </div>
      <div class="box-body" style="font-size: 12px !important;">


        <table class="table table-bordered" id="receipts_table">
          <thead>
            <tr>
              <th>#</th>
              <th>Appointments No</th>
              <th>Patient ID</th>
              <th>Patient Name</th>
              <th>Contact</th>
              <th>Gender</th>
              <th>Action</th>
            </tr>
          </thead>
          <?php
          $count = 1;
          foreach ($new_appointments as $test) {
            $color = '';
            if ($test->status == 1) {
              $color = "#E9F1FC";
            }
            if ($test->status == 2) {
              $color = "#ffe8e7";
            }
            if ($test->status == 3) {
              $color = "#F0FFF0";
            }

          ?>
            <tr style="background-color: <?php echo $color; ?>;
            
            <?php if ($test->is_deleted == 1) { ?>
              text-decoration: line-through;
            <?php }  ?>
            ">
              <td><?php
                  echo $count++;
                  //echo $test->invoice_id; 
                  ?> </td>
              <td><?php
                  if ($test->category_id != 5) {
                    echo $test_categories[$test->category_id] . "-" . $test->today_count;
                  } else {
                    $query = "SELECT test_group_name FROM test_groups WHERE test_group_id = '" . $test->opd_doctor . "'";
                    $opd_doctor = $this->db->query($query)->result()[0]->test_group_name;
                    echo $opd_doctor . "-" . $test->today_count;
                  } ?>
              </td>
              <td><?php echo $test->patient_id; ?></td>
              <td><?php echo $test->patient_name; ?></td>
              <td><?php echo $test->patient_mobile_no; ?></td>
              <td><?php echo $test->patient_gender; ?></td>
              <td>
                <a target="new" href="<?php echo site_url(ADMIN_DIR . "dr_dashboard/patient_history/" . $test->invoice_id); ?>">View Patient Detail</a>
              </td>
            </tr>
          <?php } ?>
        </table>

      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-check"></i> Today Completed Appointments</h4>
      </div>
      <div class="box-body" style="font-size: 12px !important;">

        <table class="table table-bordered" id="receipts_table">
          <thead>
            <tr>
              <th>#</th>
              <th>Appointments No</th>
              <th>Patient ID</th>
              <th>Patient Name</th>
              <th>Contact</th>
              <th>Gender</th>
              <th>Action</th>
            </tr>
          </thead>
          <?php
          $count = 1;
          foreach ($completed_appointments as $test) {
            $color = '';
            if ($test->status == 1) {
              $color = "#E9F1FC";
            }
            if ($test->status == 2) {
              $color = "#ffe8e7";
            }
            if ($test->status == 3) {
              $color = "#F0FFF0";
            }

          ?>
            <tr style="background-color: <?php echo $color; ?>;
            
            <?php if ($test->is_deleted == 1) { ?>
              text-decoration: line-through;
            <?php }  ?>
            ">
              <td><?php
                  echo $count++;
                  //echo $test->invoice_id; 
                  ?> </td>
              <td><?php
                  if ($test->category_id != 5) {
                    echo $test_categories[$test->category_id] . "-" . $test->today_count;
                  } else {
                    $query = "SELECT test_group_name FROM test_groups WHERE test_group_id = '" . $test->opd_doctor . "'";
                    $opd_doctor = $this->db->query($query)->result()[0]->test_group_name;
                    echo $opd_doctor . "-" . $test->today_count;
                  } ?>
              </td>
              <td><?php echo $test->patient_id; ?></td>
              <td><?php echo $test->patient_name; ?></td>
              <td><?php echo $test->patient_mobile_no; ?></td>
              <td><?php echo $test->patient_gender; ?></td>
              <td>
                <a target="new" href="<?php echo site_url(ADMIN_DIR . "dr_dashboard/patient_history/" . $test->invoice_id); ?>">Edit Patient Detail</a>
                <span style="margin-left: 10px;"></span>
                <a target="new" href="<?php echo site_url(ADMIN_DIR . "dr_dashboard/print_patient_report/" . $test->invoice_id); ?>">Print</a>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
</div>


<?php echo form_close(); ?>


<div id="information_model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#information_model').modal('hide');">&times;</button>
        <h4 class="modal-title" id="information_model_title">Modal Header</h4>
      </div>
      <div class="modal-body" id="information_model_body" style="text-align:center !important">
        <div></div>
        <h3 id="invoice_id"></h3>
        <h4 id="patient_name"></h4>
        <div id="other_info" style="margin-bottom:10px; border:1px dashed #666666; border-radius:5px; "></div>
        <form action="<?php echo site_url(ADMIN_DIR . 'reception/save_and_process') ?>" method="post">
          <input type="hidden" value="" name="invoice_id" id="invoiceid" />
          <input type="hidden" value="" name="patient_group_test_ids" id="patientgrouptestids" />
          <input required="required" placeholder="Enter test token ID" type="hidden" name="test_token_id" value="<?php echo time(); ?>" />
          <input type="submit" value="Save and Process" name="save_and_process" />
        </form>
      </div>
      <div class="modal-footer" style="display: none">
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </div>
  </div>
</div>



<div id="test_form" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:90%">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#test_form').modal('hide');">&times;</button>
        <h4 class="modal-title" id="test_form_title">Test Report</h4>
      </div>
      <div class="modal-body" id="test_form_body" style="text-align:center !important">

      </div>
      <div class="modal-footer" style="display: none">
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </div>
  </div>
</div>

<div id="update_patient_detail" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Patient Detail
          <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </h5>

      </div>
      <div class="modal-body" id="patient_detail_body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  function update_patient_detail(patient_id) {
    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR); ?>/reception/get_patient_detail_by_id/",
      data: {
        patient_id: patient_id
      }
    }).done(function(data) {
      $('#patient_detail_body').html(data);

      $('#update_patient_detail').modal('show');

    });


  }

  function test_token(invoice_id, Patient_name, other_info) {
    // $('#information_model_body').html('<div style="padding: 32px; text-align: center;"><img  src="<?php echo site_url('assets/admin/preloader.gif'); ?>" /></div>');
    //alert(invoice_id);
    $('#information_model_title').html('Assign Test Token ID');
    $('#invoice_id').html("Invoice No: " + invoice_id);
    $('#patient_name').html("Patient Name: " + Patient_name);
    $('#other_info').html($('#in_' + invoice_id).val());
    $('#patientgrouptestids').val($('#patient_group_test_ids_' + invoice_id).val());
    $('#invoiceid').val(invoice_id);

    $('#information_model').modal('show');

  }

  function get_patient_test_form(invoice_id) {

    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR); ?>/lab/get_patient_test_form/",
      data: {
        invoice_id: invoice_id
      }
    }).done(function(data) {
      $('#test_form_body').html(data);
      $('#test_form').modal('show');
    });
  }

  function get_patient_test_report(invoice_id) {

    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR); ?>/lab/get_patient_test_report/",
      data: {
        invoice_id: invoice_id
      }
    }).done(function(data) {
      $('#test_form_body').html(data);
      $('#test_form').modal('show');
    });
  }


  prices = [];
  var test_total_price = 0;


  function set_price(test_group_id, test_group_name, test_price, test_time, main) {

    if (main == 1) {
      test_total_price = 0;
      prices = [];
      $('#validate').val("");
      $('.test_list').each(function() {
        $(this).prop('checked', false)
      });

      if (test_group_id == 4) {
        $('#dr_app_list').show();
        $('.appointment_numbers').prop('required', true);
        $('#multiple_token_option').show();
        //single_token();
        $("#singleToken").prop("checked", true);
        $('#second_patient_for').hide();
        $('.patient2').attr('required', false);
      } else {
        $('#dr_app_list').hide();
        $('.appointment_numbers').prop('required', false);
        $('#multiple_token_option').hide();
        $("#singleToken").prop("checked", true);
        $('#second_patient_for').hide();
        $('.patient2').attr('required', false);
      }

    } else {
      <?php $query = "SELECT * FROM `test_groups` WHERE category_id=5";
      $test_group_names = $this->db->query($query)->result();
      foreach ($test_group_names as $test_group_name) {
      ?>
        delete prices['<?php echo $test_group_name->test_group_name; ?>'];
      <?php } ?>

      $('.appointments').each(function() {
        $(this).prop('checked', false)
      });

      $('#dr_app_list').hide();
      $('.appointment_numbers').prop('required', false);


    }


    if ($('#TG_' + test_group_id).is(':checked')) {
      $('#validate').val("1");
      test_total_price = 0;
      prices[test_group_name] = {
        'price': test_price,
        'test_time': test_time,
        'test_group_id': test_group_id
      };
    } else {
      test_total_price = 0;
      delete prices[test_group_name];
      $('#validate').val("");
    }
    // prices.forEach(element => console.log(element));
    var price_list = '<table class="table table-bordered"><tr><td>#</td><td>Test Name</td><td>Price</td></tr>';

    var count = 0;
    var $testGrouupIds = "";
    for (var key in prices) {

      if (prices.hasOwnProperty(key))
        count = parseInt(count) + 1;
      price_list += '<tr><td>' + count + '</td>';
      price_list += '<td>' + key + '</td>';
      price_list += '<td>' + prices[key].price + '</td>';
      price_list += '</td></tr>';
      test_total_price = parseInt(test_total_price) + parseInt(prices[key].price);
      $testGrouupIds = $testGrouupIds + prices[key].test_group_id + ',';


    }
    $('#testGroupIDs').val($testGrouupIds);
    price_list += '</table>';

    $('#test_price_list').html(price_list);
    $('#test_total_price').html(test_total_price + '.00 Rs.');
    var discount = $('#discount').val();

    $('#discount_total').html(discount + '.00 Rs.');
    var payable = parseInt(test_total_price) - discount;
    $('#payable').html(payable + '.00 Rs.');

    //prices.forEach(test_price_list_function);
    // for (i = 0; i < prices.length; i++) {
    //     console.log(numbers[i]);
    //   } 


  }

  function update_price_list() {
    $('#test_total_price').html(test_total_price + '.00 Rs.');
    var discount = $('#discount').val();

    $('#discount_total').html(discount + '.00 Rs.');
    var payable = parseInt(test_total_price) - discount;
    $('#payable').html(payable + '.00 Rs.');
    if (discount > 0) {
      $('#dicount_options').show();
      $('#discount_type_id').attr("required", true);
      $('#discount_ref_by').attr("required", true);
    } else {
      $('#dicount_options').hide();
      $('#discount_type_id').attr("required", false);
      $('#discount_ref_by').attr("required", false);
    }


  }

  function test_price_list_function(test_group_name, values) {
    //alert();
    //$('#test_price_list').html(price_list);
    console.log(test_group_name);
  }

  function single_token() {
    $("#singleToken").prop("checked", true);
    $('#second_patient_for').hide();
    $('.patient2').attr('required', false);

  }

  function multiple_token() {
    $("#multipleToken").prop("checked", true);
    $('#second_patient_for').show();
    $('.patient2').attr('required', true);
  }
</script>

<script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery.inputmask.bundle.min.js"); ?>" type="text/javascript"></script>
<script>
  $(document).ready(function() {

    $("body").on('focus', '#patient_mobile_no', function() {
      $(this).inputmask("0999 9999999");
    });

  });
</script>
<?php $this->load->view(ADMIN_DIR . "reception/reception_footer"); ?>