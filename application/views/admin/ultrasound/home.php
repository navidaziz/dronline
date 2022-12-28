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
} ?>
<div class="row">
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-12">
        <div class="box border blue" id="messenger">
          <div class="box-title">
            <h4><i class="fa fa-forward"></i>Forwarded Ultrasound</h4>
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
                  <h4 style="margin-top: -5px;"><strong>Tareen Infertility & Impotence Center</strong></h4>
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
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <!-- <th>Mobile</th> -->
                  <th>Ultrasound</th>
                  <!-- <th>Price</th>
              <th>Discount</th> 
              <th>Rs:</th>-->
                  <th>Status</th>
                </tr>
              </thead>
              <?php foreach ($forwarded_tests as $test) { ?>
                <tr style="background-color: #E9F1FC;">
                  <td><?php echo $test->invoice_id; ?> </td>
                  <td><?php echo $test->patient_name; ?> <br />
                  </td>
                  <!-- <td><?php echo $test->patient_mobile_no; ?></td> -->
                  <td>

                    <?php
                    $query = "SELECT
                    `test_groups`.`test_group_name`,
                    `test_groups`.`test_group_id`
                  FROM
                  `invoice_test_groups`,
                  `test_groups` 
                  WHERE `invoice_test_groups`.`test_group_id` = `test_groups`.`test_group_id`
                  AND `invoice_test_groups`.`invoice_id` = '" . $test->invoice_id . "'";
                    $query_result = $this->db->query($query);
                    $patient_tests = $query_result->result();
                    $tests = '';
                    foreach ($patient_tests as $patient_test) {
                      $tests .= $patient_test->test_group_name . ',';
                    }
                    echo $tests;
                    ?>

                  </td>
                  <!-- <td><?php echo $test->price; ?></td>
              <td><?php echo $test->discount; ?></td> 
              <td><?php echo $test->total_price; ?></td> -->
                  <td>
                    <?php if ($test->status == 1) {

                      $other_info = 'Patient Name: ' . $test->patient_name . '<br />';
                      $other_info .= 'Mobile No: ' . $test->patient_mobile_no . '<br />';
                      $other_info .= 'Address: ' . $test->patient_address . '<br />';
                      $other_info .= 'Refered By: ' . $test->doctor_name . ' (' . $test->doctor_designation . ')<br />';
                      $other_info .= 'Ultrasound: <strong style=\'font-size:15px !important; margin-top:5px\'>';
                      $patient_group_test_ids = '';
                      //get the test groups for the pacient...
                      $query = "SELECT
                    `test_groups`.`test_group_name`,
                    `test_groups`.`test_group_id`
                  FROM
                  `invoice_test_groups`,
                  `test_groups` 
                  WHERE `invoice_test_groups`.`test_group_id` = `test_groups`.`test_group_id`
                  AND `invoice_test_groups`.`invoice_id` = '" . $test->invoice_id . "'";
                      $query_result = $this->db->query($query);
                      $patient_tests = $query_result->result();
                      foreach ($patient_tests as $patient_test) {
                        $other_info .= $patient_test->test_group_name . ', ';
                        $patient_group_test_ids .= $patient_test->test_group_id . ', ';
                      }
                      $other_info .= '</strong>';

                    ?>

                      <input id="in_<?php echo $test->invoice_id; ?>" type="hidden" value="<?php echo @$other_info; ?>" />
                      <input id="patient_group_test_ids_<?php echo $test->invoice_id; ?>" type="hidden" value="<?php echo @$patient_group_test_ids; ?>" />
                      <a href="#" onclick="test_token('<?php echo $test->invoice_id; ?>', '<?php echo $test->patient_name;  ?>', '', '<?php echo $test->test_token_id;  ?>' )">Process</a>
                    <?php  } ?>

                  </td>
                </tr>
              <?php } ?>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="box border blue" id="messenger">
          <div class="box-title">
            <h4><i class="fa fa-clock-o"></i>Inprogress Ultrasound</h4>
          </div>


          <div class="box-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <!-- <th>Mobile</th> -->
                  <th>Ultrasound</th>
                  <!-- <th>Price</th>
              <th>Discount</th> 
              <th>Rs:</th>-->
                  <th>Status</th>
                </tr>
              </thead>
              <?php foreach ($inprogress_tests as $test) { ?>
                <tr style="background-color: #ffe8e7">
                  <td><?php echo $test->invoice_id; ?> </td>
                  <td><?php echo $test->patient_name; ?> <br />
                  </td>
                  <!-- <td><?php echo $test->patient_mobile_no; ?></td> -->
                  <td>

                    <?php
                    $query = "SELECT
                    `test_groups`.`test_group_name`,
                    `test_groups`.`test_group_id`
                  FROM
                  `invoice_test_groups`,
                  `test_groups` 
                  WHERE `invoice_test_groups`.`test_group_id` = `test_groups`.`test_group_id`
                  AND `invoice_test_groups`.`invoice_id` = '" . $test->invoice_id . "'";
                    $query_result = $this->db->query($query);
                    $patient_tests = $query_result->result();
                    $tests = '';
                    foreach ($patient_tests as $patient_test) {
                      $tests .= $patient_test->test_group_name . ',';
                    }
                    echo $tests;
                    ?>

                  </td>
                  <!-- <td><?php echo $test->price; ?></td>
              <td><?php echo $test->discount; ?></td> 
              <td><?php echo $test->total_price; ?></td>-->
                  <td>

                    <?php if ($test->status == 2) { ?>
                      <a href="javascript:get_patient_test_form('<?php echo $test->invoice_id; ?>')">Add Result</a>

                    <?php  } ?>

                  </td>
                </tr>
              <?php } ?>
            </table>
          </div>



        </div>
      </div>

    </div>
  </div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-12">
        <div class="box border blue" id="messenger">
          <div class="box-title">
            <h4><i class="fa fa-check"></i>Completed Ultrasound</h4>
          </div>


          <div class="box-body">
            <table class="table table-bordered" id="completed_test_list">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <!-- <th>Mobile</th> -->
                  <th>Ultrasound</th>
                  <!-- <th>Price</th>
              <th>Discount</th> 
              <th>Rs:</th>-->
                  <th>Status</th>
                </tr>
              </thead>
              <?php foreach ($completed_tests as $test) {  ?>
                <tr style="background-color: #F0FFF0;">
                  <td><?php echo $test->invoice_id; ?> </td>
                  <td><?php echo $test->patient_name; ?>

                  </td>
                  <!-- <td><?php echo $test->patient_mobile_no; ?></td> -->
                  <td>

                    <?php
                    $query = "SELECT
                    `test_groups`.`test_group_name`,
                    `test_groups`.`test_group_id`
                  FROM
                  `invoice_test_groups`,
                  `test_groups` 
                  WHERE `invoice_test_groups`.`test_group_id` = `test_groups`.`test_group_id`
                  AND `invoice_test_groups`.`invoice_id` = '" . $test->invoice_id . "'";
                    $query_result = $this->db->query($query);
                    $patient_tests = $query_result->result();
                    $tests = '';
                    foreach ($patient_tests as $patient_test) {
                      $tests .= $patient_test->test_group_name . ',';
                    }
                    echo $tests;
                    ?>

                  </td>
                  <!-- <td><?php echo $test->price; ?></td>
              <td><?php echo $test->discount; ?></td> 
              <td><?php echo $test->total_price; ?></td>-->
                  <td>

                    <?php if ($test->status == 3) { ?>
                      <a href="javascript:get_patient_test_form('<?php echo $test->invoice_id; ?>');">Edit Result</a>
                      <span style="margin-left: 10px;"></span>
                      <a href="javascript:get_patient_test_report('<?php echo $test->invoice_id; ?>')">
                        <i class="fa fa-eye" aria-hidden="true"></i> Report</a>
                      <!-- <a style="margin-left: 10px;" target="new" href="<?php echo site_url(ADMIN_DIR . "lab/print_patient_test_report/$test->invoice_id") ?>"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
                <?php  } ?> -->
                  </td>
                </tr>
              <?php } ?>
            </table>
          </div>

        </div>
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
        <h4 class="modal-title" id="test_form_title">Ultrasound Report</h4>
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
  function get_patient_test_report(invoice_id) {

    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR); ?>/ultrasounds/get_patient_test_report/",
      data: {
        invoice_id: invoice_id
      }
    }).done(function(data) {
      $('#test_form_body').html(data);
      $('#test_form').modal('show');
    });
  }
</script>
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
        <form onsubmit="return validate_token()" action="<?php echo site_url(ADMIN_DIR . 'ultrasounds/save_and_process') ?>" method="post">
          <input type="hidden" value="" name="invoice_id" id="invoiceid" />
          <input type="hidden" value="" name="patient_group_test_ids" id="patientgrouptestids" />
          <input required="required" placeholder="Enter test token ID" type="text" name="test_token_id" id="test_token_id" value="" />
          <input type="hidden" value="" name="testTokenId" id="testTokenId" />
          <input type="submit" value="Save and Process" name="save_and_process" />
        </form>
      </div>
      <div class="modal-footer" style="display: none">
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </div>
  </div>
</div>

<script>
  function validate_token() {
    var testTokenId = $('#testTokenId').val();
    //alert(testTokenId);
    var test_token_id = $('#test_token_id').val();
    //alert(test_token_id);
    if (testTokenId != test_token_id) {
      alert("invalid token");
      return false;
    }

  }
</script>



<div id="test_form" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:90%">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#test_form').modal('hide');">&times;</button>
        <h4 class="modal-title" id="test_form_title">Ultrasound Report</h4>
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
  function test_token(invoice_id, Patient_name, other_info, token_id) {
    // $('#information_model_body').html('<div style="padding: 32px; text-align: center;"><img  src="<?php echo site_url('assets/admin/preloader.gif'); ?>" /></div>');
    //alert(invoice_id);
    //alert(token_id);
    $('#testTokenId').val(token_id);
    var sub_token = token_id.substr(0, 6)
    $('#test_token_id').val(sub_token);
    $('#information_model_title').html('Verify Ultrasound Token ID');
    $('#invoice_id').html("Invoice No: " + invoice_id);
    $('#patient_name').html("Patient Name: " + Patient_name);
    $('#other_info').html($('#in_' + invoice_id).val());
    $('#patientgrouptestids').val($('#patient_group_test_ids_' + invoice_id).val());
    $('#invoiceid').val(invoice_id);

    $('#information_model').modal('show');




    /*if(id){ id=id; }else{ id=0; }
    $.ajax({
      type: "POST",
      url: site_url + "/"+controller+"/"+con_function+"/",
      data: {id:id}
    }).done(function(data) {
      //console.log(data);
      $('#information_model_body').html(data);
    });*/
  }

  function get_patient_test_form(invoice_id) {

    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR); ?>/ultrasounds/get_patient_test_form/",
      data: {
        invoice_id: invoice_id
      }
    }).done(function(data) {
      //console.log(data);
      // test_form_title
      $('#test_form_body').html(data);
      $('#test_form').modal('show');


    });
  }
</script>

<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/jquery.dataTables.css") ?>">

<script type="text/javascript" charset="utf8" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/jquery.dataTables.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/dataTables.buttons.min.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/jszip.min.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/pdfmake.min.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/vfs_fonts.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/buttons.html5.min.js") ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/buttons.print.min.js") ?>"></script>


<script>
  $(document).ready(function() {
    $('#completed_test_list').DataTable({
      "pageLength": 13,
      "lengthChange": false,
      "sorting": false
    });
  });
</script>
<?php $this->load->view(ADMIN_DIR . "reception/reception_footer"); ?>