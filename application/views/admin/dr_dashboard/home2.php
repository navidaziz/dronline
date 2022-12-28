<?php $this->load->view(ADMIN_DIR . "reception/reception_header"); ?>



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
  <div class="col-md-3">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Patient Detail</h4>
      </div>
      <div class="box-body">

        <table style="width: 100%;">
          <tr>
            <td style="text-align: center; color: #BC181D;"><?php $file = pathinfo($system_global_settings[0]->sytem_admin_logo);
                                                            $log = $file['dirname'] . '/' . $file['filename'] . '_thumb.' . $file['extension'];
                                                            ?>
              <!-- <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"> 
        <img src="<?php echo site_url("assets/uploads/" . $log); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" 
        title="<?php echo $system_global_settings[0]->system_title ?>" class="img-responsive " style="width:40px !important;"></a>-->
              <h5 style="margin-top: -5px;"><strong>Tareen Infertility & Impotence Center</strong></h5>
              <h5 style="margin-top: -5px;">Peshawar</h5>
            </td>
            <td>
              <ul class="nav navbar-nav pull-right" style="margin-top: -20px;">
                <li style="float:right" class="dropdown user" id="header-user"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img alt="" src="<?php
                                                                                                                                                              $file = pathinfo($this->session->userdata("user_image"));


                                                                                                                                                              echo site_url("assets/uploads/" . @$file['dirname'] . '/' . @$file['filename'] . '_thumb.' . @$file['extension']); ?>" /> <span class="username"><?php echo $this->session->userdata("user_title"); ?></span> <i class="fa fa-angle-down"></i> </a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo site_url(ADMIN_DIR . "users/update_profile"); ?>"><i class="fa fa-user"></i> Update Profile</a></li>
                    <li><a href="<?php echo site_url(ADMIN_DIR . "users/logout"); ?>"><i class="fa fa-power-off"></i> Log Out</a></li>
                  </ul>
                </li>




              </ul>
            </td>
          </tr>
        </table>
        <hr style="margin-top: -5px;" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <table style="width: 100%;">

          <tr>
            <td>Patient Name: </td>

            <td>
              <input style="display: none;" type="text" name="validate" id="validate" required="required" />

              <input type="hidden" name="patientID" id="patientID" />

              <input type="text" name="patient_name" value="" id="patient_name" autocomplete="off" class="ui-autocomplete-input" style="" required="required" title="Name" placeholder="Name">

              <span id="please_wait"></span>

            </td>


            <script>
              $(function() {
                var availableTags = [
                  <?php $query = "SELECT `patient_id`, `patient_name` 
                                  FROM `patients` 
                                  WHERE DATE(`created_date`) = DATE(NOW()) GROUP BY `patient_name`";
                  $today_patients = $this->db->query($query)->result();
                  foreach ($today_patients as $patient) { ?> "<?php echo $patient->patient_name; ?>", "<?php echo $patient->patient_id; ?>",
                  <?php } ?>


                ];
                $("#patient_name").autocomplete({
                  source: availableTags
                });
              });

              $('#patient_name').on('keydown', function(e) {
                if (e.keyCode == 13) {
                  var patient = $('#patient_name').val();
                  $('#please_wait').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
                  $.ajax({
                    type: "POST",
                    url: "<?php echo site_url(ADMIN_DIR . "/reception/get_patient_detail"); ?>",
                    data: {
                      patient: patient
                    }
                  }).done(function(data) {
                    var patient = jQuery.parseJSON(data);

                    $('#patientID').val(patient.patient_id);
                    $('#patient_address').val(patient.patient_address);
                    $('#patient_age').val(patient.patient_age);
                    if (patient.patient_gender == 'Male') {
                      $('#male').attr('checked', true);
                    } else {
                      $('#female').attr('checked', true);
                    }
                    $('#patient_mobile_no').val(patient.patient_mobile_no);

                  });
                  $('#please_wait').hide();
                }

              });
            </script>

          </tr>

          <tr>
            <td>Address: </td>
            <td><input type="text" name="patient_address" value="" id="patient_address" class="for m-control" style="" required="required" title="Address" placeholder="Address"></td>
          </tr>
          <tr>
            <td>Age: </td>
            <td><input type="text" name="patient_age" value="" id="patient_age" class="for m-control" style="" required="required" title="Patient Age" placeholder="Patient Age"></td>
          </tr>
          <tr>
            <td>Sex: </td>
            <td><input type="radio" name="patient_gender" value="Male" id="male" style="" required="required" class="uniform"><label for="patient_gender" style="margin-left:10px;">Male</label><input type="radio" name="patient_gender" value="Female" id="female" style="" required="required" class="uniform"><label for="patient_gender" style="margin-left:10px;">Female</label></td>
          </tr>
          <tr>
            <td>Referred By: </td>
            <td><select class="for m-control" required name="refered_by">
                <option value="14">Self</option>
                <?php

                $query = "SELECT * FROM `doctors` WHERE `status`=1";
                $query_result = $this->db->query($query);
                $doctors = $query_result->result();

                foreach ($doctors as $doctor) { ?>
                  <option value="<?php echo $doctor->doctor_id; ?>"><?php echo $doctor->doctor_name; ?></option>
                <?php }  ?>
                <?php echo form_error("refered_by", "<p class=\"text-danger\">", "</p>"); ?>

              </select></td>
          </tr>

          <tr>
            <td>Mobile No:</td>
            <td><input type="text" minlength="11" name="patient_mobile_no" value="" id="patient_mobile_no" class="for m-control" style="" title="Mobile No" placeholder="Mobile No"></td>


          </tr>

        </table>
        <hr />




        <div>



          <input type="text" name="groups" id="groups" />
          <script>
            $(function() {
              var groupsTags = [
                <?php foreach ($test_groups as $test_group) { ?> "<?php echo $test_group->test_group_name; ?>", "<?php echo $test_group->test_group_id; ?>",
                <?php } ?>


              ];
              $("#groups").autocomplete({
                source: groupsTags
              });
            });
          </script>

          <div id="test_price_list" style="min-height: 130px;">
            <table class="table table-bordered">
              <tr>
                <td>#</td>
                <td>Test Name</td>
                <td>Price</td>
              </tr>

            </table>
          </div>
          <style>
            table>thead>tr>th,
            .table>tbody>tr>th,
            .table>tfoot>tr>th,
            .table>thead>tr>td,
            .table>tbody>tr>td,
            .table>tfoot>tr>td {
              padding: 5px !important;
            }
          </style>

          <hr />
          <div style="margin-bottom:10px; border:1px dashed #666666; border-radius:5px;  padding:5px; margin-bottom:5px">
            <table style="width:100%">
              <tr>
                <td rowspan="3"><strong>Discount:<strong> <br />
                      <input onkeyup="update_price_list()" type="number" name="discount" value="0" id="discount" class="for m-control" style="width:80px" /></td>
                <th>Total Price:</th>
                <td id="test_total_price">00.00 Rs. </td>
              </tr>
              <tr>
                <th>Discount: </th>
                <td id="discount_total">00.00 Rs.</td>
              </tr>
              <tr>
                <th>Payable: </th>
                <th id="payable">00.00 Rs.</th>
              </tr>
            </table>
            <input type="hidden" name="testGroupIDs" value="" id="testGroupIDs" />
          </div>
          <input type="submit" name="submit" value="Save and Print" class="btn btn-primary" style="width:100%">
        </div>


      </div>
    </div>
  </div>
  <div class="col-md-4" style="padding-left:1px !important; padding-right:1px !important; ">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-flask"></i>Service Tokens (Reception)</h4>
      </div>
      <div class="box-body">
        <div class="row" style="font-size: 12px !important;">
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

          <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
          <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
          <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
          <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
          <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
          <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
          <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

          <div class="col-md-12">

            <table id="testGroupsTable" class="display">
              <thead>
                <tr>
                  <th>#</th>
                  <!-- <th>G_ID</th> -->
                  <th>Test Group Name</th>
                  <th>Time</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($test_groups as $test_group) { ?>
                  <tr>
                    <td>
                      <input style="display: inline;" name="test_group_id[]" id="TG_<?php echo $test_group->test_group_id; ?>" onclick="set_price('<?php echo $test_group->test_group_id; ?>', '<?php echo $test_group->test_group_name; ?>', '<?php echo $test_group->test_price; ?>', '<?php echo $test_group->test_time; ?>')" type="checkbox" value="<?php echo $test_group->test_group_id; ?>" />
                    </td>
                    <!-- <td><?php echo $test_group->test_group_id; ?></td> -->
                    <td><strong style="margin-left:2px;">
                        <?php echo $test_group->test_group_name; ?>
                      </strong></td>

                    <td><?php
                        if ($test_group->category_id != 5) {
                          echo $test_group->test_time . " min";
                        }
                        ?></td>
                    <td><?php echo $test_group->test_price; ?> Rs.</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <script>
              $(document).ready(function() {
                $('#testGroupsTable').DataTable({
                  "pageLength": 10,
                  "lengthChange": false

                });
              });
              $(document).ready(function() {
                $('#receipts_table').DataTable({
                  "paging": false,
                  "lengthChange": false,
                  "sorting": false
                });
              });
            </script>
          </div>



        </div>



      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-file"></i>Receipt / LAB Tests Status / LAB Test Reports</h4>
      </div>
      <div class="box-body" style="font-size: 12px !important;">

        <span style="cursor: pointer;" class="pull-left" onclick="get_today_progress_report()">
          <i class="fa fa-bar-chart" aria-hidden="true"></i> Today Report</span>

        <script>
          function get_today_progress_report() {
            $.ajax({
              type: "POST",
              url: "<?php echo site_url(ADMIN_DIR); ?>/reception/today_progress_report/",
              data: {}
            }).done(function(data) {

              $('#test_form_title').html('Today Report');
              $('#test_form_body').html(data);
              $('#test_form').modal('show');


            });
          }
        </script>


        <script>
          function get_patient_search_result() {
            var search = $('#search').val();
            if (search != "") {
              $.ajax({
                type: "POST",
                url: "<?php echo site_url(ADMIN_DIR); ?>/lab/get_patient_search_result/",
                data: {
                  search: search
                }
              }).done(function(data) {
                $('#search_result').html(data);
              });
            } else {
              $('#search_result').html("");
            }
          }
        </script>

        <!-- Search Test <input onkeyup="get_patient_search_result()" type="text" name="search" id="search" class="form-control" style="width: 200px; display: inline;" /> 
        <div style="padding: 1px; text-align: right;">
        </div>
        <div id="search_result"></div>-->
        <table class="table table-bordered" id="receipts_table" style="margin-top: -10px;">
          <thead>
            <tr>
              <th>#</th>
              <th>Category</th>
              <th>Name</th>

              <th>Gender</th>
              <th>Receipts</th>
              <!-- <th>Price</th>
              <th>Discount</th> -->
              <th>Rs:</th>
              <th>Status</th>
            </tr>
          </thead>
          <?php foreach ($all_tests as $test) {
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
              <td><?php echo $test->invoice_id; ?> </td>
              <td><?php
                  if ($test->category_id != 5) {
                    echo $test_categories[$test->category_id] . "-" . $test->today_count;
                  } else {
                    $query = "SELECT test_group_name FROM test_groups WHERE test_group_id = '" . $test->opd_doctor . "'";
                    $opd_doctor = $this->db->query($query)->result()[0]->test_group_name;
                    echo $opd_doctor . "-" . $test->today_count;
                  } ?>
              </td>
              <td><?php echo $test->patient_name; ?></td>
              <!-- <td><?php echo $test->patient_mobile_no; ?></td> -->
              <td><?php echo $test->patient_gender; ?></td>
              <td>
                <a style="margin-left: 10px;" target="new" href="<?php echo site_url(ADMIN_DIR . "lab/print_patient_test_receipts/$test->invoice_id") ?>"><i class="fa fa-print" aria-hidden="true"></i> Receipt</a>

              </td>
              <!-- <td><?php echo $test->price; ?></td>
              <td><?php echo $test->discount; ?></td> -->
              <td><?php echo $test->total_price; ?></td>
              <td>
                <?php if ($test->category_id == 1) {
                  if ($test->status == 1 and $test->is_deleted == 0) { ?>

                    <!-- <input id="in_<?php echo $test->invoice_id; ?>" type="hidden" value="<?php echo @$other_info; ?>" />
                  <input id="patient_group_test_ids_<?php echo $test->invoice_id; ?>" type="hidden" value="<?php echo @$patient_group_test_ids; ?>" />
                  <a href="#" onclick="test_token('<?php echo $test->invoice_id; ?>')">New</a> -->
                    New
                    <a href="<?php echo site_url(ADMIN_DIR . "lab/delete_invoice/$test->invoice_id") ?>" class="pull-right"><i class="fa fa-times" style="color:red"></i> Delete</a>

                  <?php

                  } ?>
                  <?php if ($test->status == 2) { ?>
                    Inprogress
                  <?php  } ?>
                  <?php if ($test->status == 3) { ?>

                    <a style="margin-left: 10px;" target="new" href="<?php echo site_url(ADMIN_DIR . "lab/print_patient_test_report/$test->invoice_id") ?>"><i class="fa fa-print" aria-hidden="true"></i> Print Report</a>
                <?php  }
                }  ?>
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

<script>
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


  function set_price(test_group_id, test_group_name, test_price, test_time) {



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
  }

  function test_price_list_function(test_group_name, values) {
    alert();
    //$('#test_price_list').html(price_list);
    console.log(test_group_name);
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