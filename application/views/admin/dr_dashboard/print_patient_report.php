<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>
    Patient Report PID:<?php echo $invoice_detail->patient_id; ?>-HNo:<?php echo $invoice_detail->invoice_id; ?>
  </title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>Patient Report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/responsive.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css" media="screen,print" />


  <style>
    body {
      background: rgb(204, 204, 204);

    }

    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
      width: 21cm;
      /* height: 29.7cm;  */
      height: auto;
    }

    page[size="A4"][layout="landscape"] {
      width: 29.7cm;
      height: 21cm;
    }

    page[size="A3"] {
      width: 29.7cm;
      height: 42cm;
    }

    page[size="A3"][layout="landscape"] {
      width: 42cm;
      height: 29.7cm;
    }

    page[size="A5"] {
      width: 14.8cm;
      height: 21cm;
    }

    page[size="A5"][layout="landscape"] {
      width: 21cm;
      height: 14.8cm;
    }

    @media print {

      body,
      page {
        margin: 0;
        box-shadow: 0;
        color: black;
      }



    }


    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      padding: 4px;
      line-height: 1;
      vertical-align: top;
      border-top: 1px solid #ddd;
      font-size: 12px !important;
      color: black;
    }
  </style>
</head>

<body>
  <page size='A4'>

    <div style="padding-left: 40px; padding-right: 40px; padding-top:0px !important;" contenteditable="true">

      <table style="width: 100%;" style="color:black">
        <thead>
          <tr>
            <th style="">

              <?php

              $query = "SELECT `reported_by` FROM `invoices` 
                        WHERE `invoice_id`= '" . $invoice_detail->invoice_id . "' ";
              $reported_by = $this->db->query($query)->row()->reported_by;

              $query = "SELECT
                                `roles`.`role_title`,
                                `users`.`user_title` ,
                                `users`.`designation` ,
                                `users`.`user_mobile_number`
                            FROM `roles`,
                            `users` 
                            WHERE `roles`.`role_id` = `users`.`role_id`
                            AND `users`.`user_id`='" . $reported_by . "'";
              $opd_doctor = $this->db->query($query)->row();
              ?>
              <h3><?php echo $opd_doctor->user_title ?></h3>
              <h4><?php echo $opd_doctor->designation ?></h4>
              <h4>Contact No: <?php echo $opd_doctor->user_mobile_number ?></h4>
            </th>
            <th style="text-align: right;">

              <h3><?php echo $system_global_settings[0]->system_title ?></h3>
              <h4><?php echo $system_global_settings[0]->system_sub_title ?></h4>
              <h4>Contact No: 0000-000000</h4>

            </th>
          </tr>
          <tr>
            <td colspan="2">
              <table style="width: 100%; margin-top: 5px; margin-bottom: 10px;">
                <tr>
                  <td style="width: 40%;">

                    <div style="bor der: 1px dashed black; margin-top: 5px; padding:5px">
                      <table style="text-align: left; width:100%; font-size: 12px !important; color:black;">
                        <tr>
                          <th>Patient ID: </th>
                          <td><?php echo $invoice_detail->patient_id; ?></td>
                        </tr>
                        <tr>
                          <th>Patient Name: </th>
                          <td><?php echo trim(ucwords(strtolower($invoice_detail->patient_name))); ?></td>
                        </tr>
                        <tr>
                          <th>Age / Sex: </th>
                          <td><?php echo @$invoice_detail->patient_age; ?> / <?php echo $invoice_detail->patient_gender; ?></td>
                        </tr>
                        <tr>
                          <th>Mobile No: </th>
                          <td><?php echo $invoice_detail->patient_mobile_no; ?></td>
                        </tr>
                        <tr>
                          <th>Address: </th>
                          <td><?php echo trim(ucwords(strtolower($invoice_detail->patient_address))); ?></td>
                        </tr>
                      </table>
                    </div>
                  </td>
                  <td style="width: 20%;"></td>
                  <td tyle="width: 40%;">
                    <div style="bor der: 1px dashed black; margin-top: 5px; padding:5px;">
                      <table style="text-align: left; width:100%; font-size: 12px !important; color:black">
                        <tr>
                          <th>History No: </th>
                          <td> <?php echo $invoice_detail->invoice_id; ?></td>
                        </tr>

                        <tr>
                          <th>Refereed By:</th>
                          <td><?php echo str_replace("Muhammad", "M.", $invoice_detail->doctor_name) . "( " . $invoice_detail->doctor_designation . " )"; ?></td>
                        </tr>
                        <tr>
                          <th>Registered:</th>
                          <td><?php echo date("d M, Y h:i:s", strtotime($invoice_detail->created_date)); ?></td>
                        </tr>
                        <!-- <tr>
                          <th>Received:</th>
                          <td><?php echo date("d M, Y h:i:s", strtotime($invoice_detail->process_date)); ?></td>
                        </tr>
                        <tr>
                          <th>Reported:</th>
                          <td><?php echo date("d M, Y h:i:s", strtotime($invoice_detail->reported_date)); ?></td>
                        </tr> -->
                        <tr>
                          <th>Registered By</th>
                          <td>
                            <?php

                            $query = "SELECT `created_by` FROM `invoices` WHERE `invoice_id`= '" . $invoice_detail->invoice_id . "' ";
                            $lab_technician_id = $this->db->query($query)->result()[0]->created_by;

                            $query = "SELECT
                                `roles`.`role_title`,
                                `users`.`user_title`  
                            FROM `roles`,
                            `users` 
                            WHERE `roles`.`role_id` = `users`.`role_id`
                            AND `users`.`user_id`='" . $lab_technician_id . "'";
                            $user_data = $this->db->query($query)->result()[0];
                            ?>
                            <small><?php echo $user_data->user_title; ?> (<?php echo $user_data->role_title; ?>)</small>

                          </td>
                        </tr>
                      </table>
                    </div>

                  </td>
                </tr>
              </table>
              <hr />
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="width: 250px; vertical-align: top;">
              <h4>Patient History</h4>

              <?php
              $where = "`patient_tests`.`invoice_id` = '" . $invoice_id . "' AND `patient_tests`.`test_group_id` = '1' ";
              $patient_history_list = $this->patient_test_model->get_patient_test_list($where, false);

              foreach ($patient_history_list as $patient_history) { ?>
                <strong><?php echo $patient_history->test_name; ?></strong>
                <p style="color: black; padding:2px;"><?php echo $patient_history->test_result; ?></p>

              <?php } ?>
            </td>
            <td style="border-left: 1px solid gray; padding-left:5px; vertical-align:top; ">
              <div style="margin-left: 10px;">

                <h4>Physician Prescriptions:</h4>
                <p><?php echo @$invoice_detail->dr_prescriptions; ?></p>
                <p style="text-align: right;">


                  <br />
                  <br />
                <p style="text-align: right;">
                  Prescribed By: <br />
                  <strong><?php echo $opd_doctor->user_title ?></strong><br />
                  <?php echo $opd_doctor->designation ?>

                </p>
                </p>

              </div>
              <br />
              <br />
              <br />
              <br />
              <br />
              <br />




            </td>
          </tr>
          <tr>
            <td colspan="2">



              <?php
              $count = 1;
              foreach ($patient_tests_groups as $patient_tests_group) { ?>
                <?php if ($patient_tests_group->test_group_id != 1) { ?>
                  <h5 style="color:black;">
                    <strong><?php echo $patient_tests_group->test_group_name; ?></strong>
                  </h5>

                  <table class="table table-bordered" style="text-align: left; font-size:10px">
                    <tr>
                      <th style="width: 200px;">TEST(s)</th>
                      <th style="width: 200px;">RESULT(s)</th>
                      <th style="width: 100px;">UNIT(s)</th>
                      <th style="width: 300px;">NORMALS</th>
                    </tr>
                    <?php
                    $normal_value = false;
                    foreach ($patient_tests_group->patient_tests as $patient_test) {
                      if ($patient_test->test_result != '') {
                        if (trim($patient_test->test_normal_value) != "") {
                          $normal_value = true;
                        }
                      }
                    }


                    foreach ($patient_tests_group->patient_tests as $patient_test) { ?>
                      <?php if ($patient_test->test_result != '') { ?>
                        <?php if ($count == 1) { ?>

                        <?php } ?>
                        <tr>
                          <th><?php echo $patient_test->test_name; ?></th>
                          <th> <?php echo $patient_test->test_result; ?> <?php echo $patient_test->result_suffix; ?></th>

                          <th style="text-align: center;"> <small> <?php echo $patient_test->unit; ?> </small></th>

                          <th style="width: 300px;">
                            <small><?php echo $patient_test->test_normal_value; ?></small>
                          </th>


                        </tr>
                      <?php } ?>
                    <?php } ?>
                  </table>
                <?php } ?>
              <?php  } ?>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <br />
              <?php if ($invoice_detail->remarks) { ?>
                <div style="text-align: left; color:black"><strong>Other Detail:</strong>
                  <p style="border: 1px dashed #ddd; border-radius: 5px; padding: 5px;">
                    <?php echo $invoice_detail->remarks; ?>
                  </p>
                </div>
              <?php } ?>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2">
              <br />
              <br />


              <p style="text-align: center;">
                <small>Print @ <?php echo date("d M, Y h:m:s A"); ?>
                  by
                  <?php
                  $query = "SELECT
                            `roles`.`role_title`,
                            `users`.`user_title`  
                        FROM `roles`,
                        `users` 
                        WHERE `roles`.`role_id` = `users`.`role_id`
                        AND `users`.`user_id`='" . $this->session->userdata("user_id") . "'";
                  $user_data = $this->db->query($query)->result()[0];
                  ?>
                  <?php echo $user_data->user_title; ?> (<?php echo $user_data->role_title; ?>)
                </small>
              </p>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>

  </page>
</body>



</html>