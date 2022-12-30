<!-- PAGE HEADER-->
<div class="row">
  <div class="col-sm-12">
    <div class="page-header" style="min-height: 10px;">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="<?php echo site_url(ADMIN_DIR . "dr_dashboard"); ?>">Dashboard</a>
        </li>

        <li>
          <i class="fa fa-table"></i> Patient History
        </li>

      </ul>


    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <div class="box border blue sticky-top" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Patient Detail</h4>
      </div>
      <div class="box-body">

        <!-- History Id: <strong><?php echo $invoice_detail->invoice_id; ?></strong><br /> -->
        Patient Id: <strong><?php echo $invoice_detail->patient_id; ?></strong><br />
        Patient Name: <strong><?php echo $invoice_detail->patient_name; ?></strong><br />
        Gender / Age: <strong><?php echo $invoice_detail->patient_gender; ?></strong> /
        <strong><?php echo $invoice_detail->patient_age; ?></strong><br />
        Mobile No: <strong><?php echo $invoice_detail->patient_mobile_no; ?></strong><br />
        Address: <strong><?php echo $invoice_detail->patient_address; ?></strong><br />
        Refered By: <strong><?php echo $invoice_detail->doctor_name . "( " . $invoice_detail->doctor_designation . " )"; ?></strong><br />
        Registered: <strong><?php echo date("d M, Y h:i:s", strtotime($invoice_detail->created_date)); ?></strong>
        <br />
        Created By:
        <?php
        $created_by = $invoice_detail->created_by;
        $query = "SELECT user_title FROM users WHERE user_id = '" . $created_by . "'";
        echo  $user_title = $this->db->query($query)->row()->user_title;
        ?>

        <h4 style="font-weight: bold !important; text-align:center;border: 1px dashed gray; padding:5px; border-radius:5px">
          <?php
          if ($invoice_detail->category_id != 5) {

            $query = "SELECT test_category FROM test_categories WHERE test_category_id= '" . $invoice_detail->category_id . "'";
            echo $Doctor_name = $this->db->query($query)->result()[0]->test_category;
            echo " - " . $invoice_detail->today_count;
          } else {
            $query = "SELECT test_group_name FROM test_groups WHERE test_group_id = '" . $invoice_detail->opd_doctor . "'";
            $opd_doctor = $this->db->query($query)->result()[0]->test_group_name;
            $Doctor_name = $opd_doctor;
            echo "" . $opd_doctor . ' - ';
            echo  $invoice_detail->today_count;
          }

          echo "<br />";
          echo date("d F, Y ", strtotime($invoice_detail->created_date));
          ?>





        </h4>
        <p style="text-align: center;">
          <?php $user_id = $invoice_detail->created_by;
          $query = "SELECT google_meet_link, google_meet_link_date_time FROM users WHERE user_id = '" . $user_id . "'";
          $video_link_detail = $this->db->query($query)->row();
          echo "<br />";
          echo "Google Meet Code: <strong style='color:red'>";
          echo substr($video_link_detail->google_meet_link, 24);
          echo "</strong>";
          ?>
        </p>
        <br />
        <p style="text-align:center">
          <strong>Case Status:</strong> <?php
                                        if ($invoice_detail->status == 1) {
                                          echo "<span class='label label-primary label-sm'>New</span>";
                                        };
                                        if ($invoice_detail->status == 2) {
                                          echo "<span class='label label-danger label-sm'>Forwarded</span>";
                                        };
                                        if ($invoice_detail->status == 3) {
                                          echo "<span class='label label-success label-sm'>Completed</span>";
                                        };
                                        ?>
        </p>

      </div>
    </div>

  </div>
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Patient History and Tests Detail</h4>
      </div>
      <div class="box-body">

        <page size='A4'>

          <div>

            <table style="width: 100%;" style="color:black">

              <tbody>
                <tr>
                  <td>

                    <?php
                    $count = 1;
                    foreach ($patient_tests_groups as $patient_tests_group) { ?>
                      <h5 style="color:black;">
                        <strong><?php echo $patient_tests_group->test_group_name; ?>
                        </strong>
                      </h5>
                      <?php if ($patient_tests_group->test_group_id == 1) { ?>
                        <div class="row">
                          <?php foreach ($patient_tests_group->patient_tests as $patient_test) { ?>

                            <div class="col-md-3" style="min-height: 150px !important;">
                              <strong><?php echo $patient_test->test_name; ?></strong>

                              <p style="border:1px dashed lightgray; padding:2px; border-radius:5px: "><?php echo $patient_test->test_result; ?></p>


                            </div>
                          <?php } ?>



                        </div>
                      <?php } else { ?>
                        <table class="table table-bordered">
                          <tr>
                            <!-- <th >#</th> -->
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
                                <?php //if ($normal_value) { 
                                ?>


                                <?php //}  
                                ?>
                                <!-- <td><?php echo $patient_test->remarks; ?> </td> -->
                              </tr>
                            <?php } ?>
                          <?php } ?>
                        </table>
                      <?php } ?>

                    <?php  } ?>

                  </td>
                </tr>
                <tr>
                  <td>
                    <br />
                    <?php if ($invoice_detail->remarks) { ?>
                      <div style="text-align: left; color:black"><strong>Remarks:</strong>
                        <p style="border: 1px dashed #ddd; border-radius: 5px; padding: 5px;">
                          <?php echo $invoice_detail->remarks; ?>
                        </p>
                      </div>
                    <?php } ?>
                  </td>
                </tr>
              </tbody>

            </table>
          </div>

        </page>
      </div>
    </div>
    <strong>Physician Prescriptions:</strong>
    <form onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo site_url(ADMIN_DIR . "dr_dashboard/add_prescriptions/" . $invoice_id); ?>" method="post">
      <table class="table">
        <tbody>
          <tr>
            <td><textarea name="dr_prescriptions" id="dr_prescriptions" onkeyup="autoheight(this)" style="width: 100%; height:150px; border-radius: 9px;"><?php echo $invoice->dr_prescriptions; ?></textarea></td>
          </tr>
          <tr>
            <td style="text-align: center;">
              <button class="btn btn-primary btn-sm" style="margin:2px; background-color:#A6A6A6; border:1px solid #A6A6A6;">Add Prescriptions</button>
            </td>
          </tr>
        </tbody>
      </table>
    </form>


    <?php if ($invoice_detail->status == 3) { ?>
      <h4 class="alert alert-success">Case is completed</h4>
    <?php } ?>




  </div>
  <div class="col-md-3">

    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Attachments</h4>
      </div>
      <div class="box-body">

        <div>

          <h3>Attachements</h3>
          <div class="row">
            <?php
            $query = "SELECT * FROM patient_attachments WHERE invoice_id = '" . $invoice_id . "'";
            $attachments = $this->db->query($query)->result();
            $count = 1;
            foreach ($attachments as $attachment) {
            ?>
              <div class="col-md-12">
                <?php echo $count . ": File Name: " . $attachment->name . "<br />
                File Detail: " . $attachment->detail . "<br />";
                $ext = strtolower(pathinfo($attachment->file, PATHINFO_EXTENSION));
                ?>
                <?php $images = array('jpg', 'jpeg', 'bmp', 'gif', 'png');
                if (in_array($ext, $images)) {
                ?>
                  <a href="javascript:view_image('<?php echo $attachment->id; ?>')">
                    <input type="hidden" id="image_<?php echo $attachment->id; ?>" value="<?php echo $attachment->file ?>" />
                    <input type="hidden" id="name_<?php echo $attachment->id; ?>" value="<?php echo $attachment->name ?>" />
                    <input type="hidden" id="detail_<?php echo $attachment->id; ?>" value="<?php echo $attachment->detail ?>" />
                    <?php echo file_type(base_url("assets/uploads/reception/" . $attachment->file), true); ?> </a>
                <?php } else { ?>
                  <?php echo file_type(base_url("assets/uploads/reception/" . $attachment->file), true); ?> </a>
                <?php } ?>
                <br />
              </div>
            <?php
              $count++;
            } ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<h4 style="text-align: center;">Previous History</h4>

<?php
$query = "SELECT invoice_id, dr_prescriptions, remarks FROM invoices 
       WHERE patient_id = '" . $invoice_detail->patient_id . "'
      and invoice_id < '" . $invoice_id . "'
      ORDER BY invoice_id DESC";
$patient_invoices = $this->db->query($query)->result();
if ($patient_invoices) {
  foreach ($patient_invoices as $patient_invoice) { ?>
    <div class="row">
      <div class="col-md-3">
        <div class="box border blue sticky-top" id="messenger">
          <div class="box-title">
            <h4><i class="fa fa-user"></i> Physician Prescriptions</h4>
          </div>
          <div class="box-body">
            <strong></strong>
            <p>
              <?php echo $patient_invoice->dr_prescriptions; ?>
            </p>
          </div>
        </div>

      </div>
      <div class="col-md-6">
        <div class="box border blue sticky-top" id="messenger">
          <div class="box-title">
            <h4><i class="fa fa-user"></i>History ID: <?php echo $patient_invoice->invoice_id; ?></h4>
          </div>
          <div class="box-body">
            <page size='A4'>

              <div>

                <table style="width: 100%;" style="color:black">

                  <tbody>
                    <tr>
                      <td>

                        <?php
                        $patient_tests_groups = "";
                        $patient_test_ids = "";
                        $query = "SELECT
                      `test_groups`.`test_group_id`,
                      `test_groups`.`test_group_name`
                      , `test_groups`.`test_time` 
                    FROM `test_groups`,
                        `patient_tests` 
                    WHERE `test_groups`.`test_group_id` = `patient_tests`.`test_group_id`
                    AND `patient_tests`.`invoice_id` = '" . $patient_invoice->invoice_id . "'
                    GROUP BY `test_groups`.`test_group_name`
                    ORDER BY `patient_tests`.`patient_test_id` ASC;";

                        $patient_tests_groups = $this->db->query($query)->result();
                        foreach ($patient_tests_groups as $patient_tests_group) {
                          $patient_test_ids .= $patient_tests_group->test_group_id . ", ";
                          $where = "`patient_tests`.`invoice_id` = '" . $patient_invoice->invoice_id . "'
			              AND `patient_tests`.`test_group_id` = '" . $patient_tests_group->test_group_id . "' ";
                          $patient_tests_group->patient_tests = $this->patient_test_model->get_patient_test_list($where, false);
                        }
                        $patient_tests_groups = $patient_tests_groups;

                        //var_dump($patient_tests_groups);

                        $count = 1;
                        foreach ($patient_tests_groups as $patient_tests_group) { ?>
                          <h5 style="color:black;">
                            <strong><?php echo $patient_tests_group->test_group_name; ?>
                            </strong>
                          </h5>
                          <?php if ($patient_tests_group->test_group_id == 1) { ?>
                            <div class="row">
                              <?php foreach ($patient_tests_group->patient_tests as $patient_test) { ?>

                                <div class="col-md-3" style="min-height: 150px !important;">
                                  <strong><?php echo $patient_test->test_name; ?></strong>

                                  <p style="border:1px dashed lightgray; padding:2px; border-radius:5px: ">
                                    <?php echo $patient_test->test_result; ?>
                                  </p>


                                </div>
                              <?php } ?>



                            </div>
                          <?php } else { ?>
                            <table class="table table-bordered">
                              <tr>
                                <!-- <th >#</th> -->
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
                                    <?php //if ($normal_value) { 
                                    ?>


                                    <?php //}  
                                    ?>
                                    <!-- <td><?php echo $patient_test->remarks; ?> </td> -->
                                  </tr>
                                <?php } ?>
                              <?php } ?>
                            </table>
                          <?php } ?>

                        <?php  } ?>

                      </td>
                    </tr>
                    <tr>
                      <td>
                        <br />
                        <strong>Remarks:</strong>
                        <p>
                          <?php echo $patient_invoice->remarks; ?>
                        </p>
                      </td>
                    </tr>
                  </tbody>

                </table>
              </div>

            </page>
          </div>
        </div>
      </div>
      <div class="col-md-3">

        <div class="box border blue" id="messenger">
          <div class="box-title">
            <h4><i class="fa fa-user"></i>Attachments</h4>
          </div>
          <div class="box-body">
            <h3>Attachements</h3>
            <div class="row">
              <?php
              $query = "SELECT * FROM patient_attachments WHERE invoice_id = '" . $patient_invoice->invoice_id . "'";
              $attachments = $this->db->query($query)->result();
              $count = 1;
              foreach ($attachments as $attachment) {
              ?>
                <div class="col-md-12">
                  <?php echo $count . ": File Name: " . $attachment->name . "<br />
                        File Detail: " . $attachment->detail . "<br />";
                  $ext = strtolower(pathinfo($attachment->file, PATHINFO_EXTENSION));
                  ?>
                  <?php $images = array('jpg', 'jpeg', 'bmp', 'gif', 'png');
                  if (in_array($ext, $images)) {
                  ?>
                    <a href="javascript:view_image('<?php echo $attachment->id; ?>')">
                      <input type="hidden" id="image_<?php echo $attachment->id; ?>" value="<?php echo $attachment->file ?>" />
                      <input type="hidden" id="name_<?php echo $attachment->id; ?>" value="<?php echo $attachment->name ?>" />
                      <input type="hidden" id="detail_<?php echo $attachment->id; ?>" value="<?php echo $attachment->detail ?>" />
                      <?php echo file_type(base_url("assets/uploads/reception/" . $attachment->file), true); ?> </a>
                  <?php } else { ?>
                    <?php echo file_type(base_url("assets/uploads/reception/" . $attachment->file), true); ?> </a>
                  <?php } ?>
                  <br />
                </div>
              <?php
                $count++;
              } ?>
            </div>

          </div>
        </div>
      </div>
    </div>

  <?php } ?>

<?php
} else { ?>
  <p>History Not Found.</p>
<?php } ?>




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
      url: "<?php echo site_url(ADMIN_DIR); ?>/lab/update_test_value/",
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
      url: "<?php echo site_url(ADMIN_DIR); ?>/lab/update_test_remark/",
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
<div id="imageView" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:90%">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#imageView').modal('hide');">&times;</button>
        <h4 class="modal-title" id="image_view_title">Image View</h4>
      </div>
      <div class="modal-body" id="image_view_body" style="text-align:center !important">
        <p id="image_detail"></p>
        <img id="image_dispaly" src="" width="auto" />
      </div>
      <div class="modal-footer" style="display: none">
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </div>
  </div>
</div>
<script>
  function view_image(id) {
    file = $('#image_' + id).val();
    name = $('#name_' + id).val();
    detail = $('#detail_' + id).val();
    image = "<?php echo site_url(); ?>assets/uploads/reception/" + file;
    $("#image_dispaly").attr("src", image);
    $('#image_view_title').html(name);
    $('#image_detail').html(detail);
    $('#imageView').modal('show');

  }
</script>
<style>
  .footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: #F5F6F6;
    color: white;
    text-align: center;
  }
</style>
<div class="footer hide_buttons">
  <section style="width: 70%; margin:0px auto; margin-bottom:5px;">

    <form action="https://psra.gkp.pk/schoolReg/online_cases/add_comment" method="post">


      <input type="hidden" name="session_id" value="2">
      <input type="hidden" name="school_id" value="61656">
      <input type="hidden" name="schools_id" value="563">
      <br />

    </form>
    <a class="btn btn-warning btn-sm" href="<?php echo site_url(ADMIN_DIR . "dr_dashboard/index"); ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Dashboard</a>


    <a target="_blank" class="btn btn-success btn-sm" href="<?php echo $video_link_detail->google_meet_link ?>">
      <img src="<?php echo site_url("assets/admin/images/google_meet.png") ?>" height="20px" />
    </a>


    <a class="btn btn-info btn-sm" href="<?php echo site_url(ADMIN_DIR . "dr_dashboard/print_patient_report/" . $invoice_detail->invoice_id); ?>" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print Report</a>

    <?php
    if ($invoice_detail->status == 2) { ?>
      <form onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo site_url(ADMIN_DIR . "dr_dashboard/mark_as_complete/$invoice_id"); ?>" method="post" style="display: inline;">
        <button class="btn btn-danger btn-sm" style="display: inline;"> <i class="fa fa-check" aria-hidden="true"></i> Mark as complete</button>
      </form>
    <?php } ?>

  </section>


</div>

<script>
  function autoheight(x) {
    x.style.height = "150px";
    x.style.height = (15 + x.scrollHeight) + "px";
  }
</script>