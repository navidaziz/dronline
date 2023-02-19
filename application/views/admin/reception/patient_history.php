<div class="row">
  <div class="col-sm-12">
    <div class="page-header" style="min-height: 10px;">
      <ul class="breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="<?php echo site_url(ADMIN_DIR . "reception"); ?>">Dashboard</a>
        </li>
        <li>
          <i class="fa fa-table"></i> Patient History
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="row">

  <div class="col-md-6">

    <div class="box border blue sticky-top" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Patient Detail</h4>
      </div>
      <div class="box-body">
        <table class="table table-bordered">
          <tr>
            <th>Patient ID</th>
            <th>Patient Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Contact No.</th>
            <th>Address</th>
          </tr>
          <tr>
            <td><strong><?php echo $invoice_detail->patient_id; ?></strong></td>
            <td><strong><?php echo $invoice_detail->patient_name; ?></strong></td>
            <td><strong><?php echo $invoice_detail->patient_gender; ?></strong></td>
            <td><strong><?php echo $invoice_detail->patient_age; ?></strong></td>
            <td><strong><?php echo $invoice_detail->patient_mobile_no; ?></strong></td>
            <td><strong><?php echo $invoice_detail->patient_address; ?></strong></td>
          </tr>
          <tr>
            <td colspan="6" style="text-align: right;">
              <!-- Refered By: <strong><?php echo $invoice_detail->doctor_name . "( " . $invoice_detail->doctor_designation . " )"; ?></strong><br />
              -->
              <small>
                Registered: <strong><?php echo date("d M, Y h:i:s", strtotime($invoice_detail->created_date)); ?></strong>

                Created By:
                <strong>
                  <?php
                  $created_by = $invoice_detail->created_by;
                  $query = "SELECT user_title FROM users WHERE user_id = '" . $created_by . "'";
                  echo  $user_title = $this->db->query($query)->row()->user_title;
                  ?>
                </strong>
                <span style="margin-left:10px;"></span>
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
              </small>
            </td>
          </tr>
        </table>
      </div>
    </div>




    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Patient History and Tests Detail</h4>
      </div>
      <div class="box-body">

        <page size='A4'>

          <div>
            <!-- Modal content-->
            <div id="information_model" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content" id="model_body"></div>
              </div>
            </div>

            <script>
              function edit_visit(id) {
                $('#information_model').modal('show');
                $('#model_body').html('please wait .....');
                $.ajax({
                  type: "POST",
                  url: "<?php echo site_url(ADMIN_DIR . "reception/get_visit_update_form/") ?>",
                  data: {
                    id: id,
                    patient_id: <?php echo $invoice_detail->patient_id; ?>,
                    history_id: <?php echo $invoice_detail->invoice_id; ?>
                  }
                }).done(function(data) {
                  $('#model_body').html(data);
                });
              }
            </script>
            <script>
              function update_test(id) {
                $('#information_model').modal('show');
                $('#model_body').html('please wait .....');
                $.ajax({
                  type: "POST",
                  url: "<?php echo site_url(ADMIN_DIR . "reception/get_patient_history_detail/") ?>",
                  data: {
                    id: id,
                    patient_id: <?php echo $invoice_detail->patient_id; ?>,
                    history_id: <?php echo $invoice_detail->invoice_id; ?>
                  }
                }).done(function(data) {
                  $('#model_body').html(data);
                });
              }
            </script>
            <script>
              function update_remarks() {
                $('#information_model').modal('show');
                $('#model_body').html('please wait .....');
                $.ajax({
                  type: "POST",
                  url: "<?php echo site_url(ADMIN_DIR . "reception/update_marks/") ?>",
                  data: {
                    patient_id: <?php echo $invoice_detail->patient_id; ?>,
                    history_id: <?php echo $invoice_detail->invoice_id; ?>
                  }
                }).done(function(data) {
                  $('#model_body').html(data);
                });
              }
            </script>
            <!-- End Modal content-->

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
                      <table class="table">
                        <?php if ($patient_tests_group->test_group_id == 1) { ?>

                          <?php foreach ($patient_tests_group->patient_tests as $patient_test) {
                            // var_dump($patient_test);
                          ?>
                            <tr>
                              <th style="width: 200px;"><?php echo $patient_test->test_name; ?></th>
                              <td>
                                <?php echo $patient_test->test_result; ?>
                                <?php echo $patient_test->result_suffix; ?>
                                <small> <?php echo $patient_test->unit; ?> </small>
                                <small class="btn btn-link" onclick="update_test('<?php echo $patient_test->patient_test_id; ?>')" class="pull-right">Edit</small>
                              </td>
                            </tr>
                          <?php } ?>
                      </table>
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
                    <?php if ($invoice_detail->remarks or 1 == 1) { ?>

                      <p>
                        <strong>Remarks:</strong>
                        <small class="pull-right">
                          <button onclick="update_remarks()" class="btn btn-link">Edit</button></small>
                      </p>
                      <div style="text-align: left; color:black">
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



    <?php if ($invoice_detail->status == 3) { ?>
      <!-- <h4 class="alert alert-success">Case is completed</h4> -->
    <?php } ?>

    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Attachments</h4>
      </div>
      <div class="box-body">

        <div>
          <div class="row">
            <?php
            $query = "SELECT * FROM patient_attachments WHERE invoice_id = '" . $invoice_id . "'";
            $attachments = $this->db->query($query)->result();
            $count = 1;
            foreach ($attachments as $attachment) {
            ?>
              <div class="col-md-3">
                <?php echo $count . ": File Name: " . $attachment->name . "<br />";
                //File Detail: " . $attachment->detail . "<br />";
                $ext = strtolower(pathinfo($attachment->file, PATHINFO_EXTENSION));
                ?>
                <?php $images = array('jpg', 'jpeg', 'bmp', 'gif', 'png');
                if (in_array($ext, $images)) {
                ?>
                  <a href="javascript:view_image('<?php echo $attachment->id; ?>')">
                    <input type="hidden" id="image_<?php echo $attachment->id; ?>" value="<?php echo $attachment->file ?>" />
                    <input type="hidden" id="name_<?php echo $attachment->id; ?>" value="<?php echo $attachment->name ?>" />
                    <input type="hidden" id="detail_<?php echo $attachment->id; ?>" value="<?php echo $attachment->detail ?>" />
                    <?php echo file_type(base_url("assets/uploads/reception/" . $attachment->file), false); ?> </a>
                <?php } else { ?>
                  <?php echo file_type(base_url("assets/uploads/reception/" . $attachment->file), true); ?> </a>
                <?php } ?>
                <br />
                <small> <a href="<?php echo site_url(ADMIN_DIR . "reception/delete_attachement2/$invoice_id/" . $attachment->id); ?>" onclick="return confirm('Are you sure? you want to remove ?')">Remove Attachment</a> </small>
                <br />
              </div>
            <?php
              $count++;
            } ?>
          </div>

        </div>
        <?php
        $user_id = $this->session->userdata("user_id");
        $query = "SELECT patient_visits.visit_id FROM patient_visits 
                  WHERE patient_id = '" . $invoice_detail->patient_id . "'
                  AND status=1
                  AND created_by = '" . $user_id . "'";
        $visit_lates = $this->db->query($query)->row();
        if ($visit_lates) {
          $visit_id = $visit_lates->visit_id;
        } else {
          $visit_id = 0;
        }
        ?>
        <form action="<?php echo site_url(ADMIN_DIR . "reception/upload_attachment"); ?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="page_re_url" value="patient_history" />
          <input type="hidden" value="<?php echo $invoice_id; ?>" name="invoice_id" />
          <input type="hidden" value="<?php echo $visit_id; ?>" name="visit_id" />
          <table class="table">
            <tr>
              <td>
                Attachment: <input required type="file" style="width: 120px;" name="attchment_file" value="" />
              </td>
              <td>
                Attachment Name: <br />
                <input required type="text" name="attachment_name" value="" />
              </td>
              <td width="500px">
                Attachment Detail:<br />
                <textarea rows="1" name="attachment_detail" style="width: 100%;"></textarea>
              </td>
              <td>
                Upload Attachment<br />
                <input class="btn btn-primary btn-small" type="submit" name="Upload Attachment" value="Upload Attachment" />
              </td>

            </tr>
          </table>
        </form>
      </div>
    </div>



  </div>
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Patient Visits</h4>
      </div>
      <div class="box-body">
        <div>
          <?php if ($invoice_detail->dr_prescriptions) { ?>
            <h5>Initial Visit</h5>
            <hr />
            <p><?php echo @$invoice_detail->dr_prescriptions; ?></p>
          <?php } ?>
          <?php
          $query = "SELECT patient_visits.*, users.user_title FROM patient_visits 
          INNER JOIN users ON (users.user_id = patient_visits.created_by)
                    WHERE patient_id = '" . $invoice_detail->patient_id . "'";
          $visits = $this->db->query($query)->result();
          if ($visits) {
            $visit_id = 0;
            foreach ($visits as $visit) { ?>


              <div style="border: 1px solid lightgray; border-radius:5px; padding:5px;">
                <h5>Visit No. <?php echo $visit->visit_no;
                              $user_id = $this->session->userdata("user_id");
                              ?>
                  <?php if ($visit->status == 0 and $visit->created_by == $user_id) { ?>
                    <small>
                      <button onclick="edit_visit('<?php echo $visit->visit_id; ?>')" class="btn btn-link btn-sm">Edit Visit</button>
                    </small>
                  <?php } ?>
                  <small class="pull-right">
                    Created By: <?php echo $visit->user_title; ?>. Dated: <?php echo date('d M, Y', strtotime($visit->created_date)); ?>
                  </small>
                </h5>
                <hr />
                <?php if ($visit->status == 1 and $visit->created_by == $user_id) { ?>

                  <form id="<?php echo $visit->visit_no; ?>_edit" <?php if ($visit->status == 0) { ?> style="display:none" <?php } ?> onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo site_url(ADMIN_DIR . "reception/update_visit"); ?>" method="post">
                    <?php $visit_id = $visit->visit_id; ?>
                    <input type="hidden" value="<?php echo $visit->visit_id; ?>" name="visit_id" />
                    <input type="hidden" value="<?php echo $invoice_detail->patient_id; ?>" name="patient_id" />
                    <input type="hidden" value="<?php echo $invoice_detail->invoice_id; ?>" name="history_id" />
                    <table class="tab le" style="width: 100%;">
                      <tbody>
                        <tr>
                          <td><textarea name="dr_prescriptions" id="dr_prescriptions" onkeyup="autoheight(this)" style="width: 100%; height:100px; border-radius: 9px;"><?php echo $visit->remarks; ?></textarea></td>
                        </tr>
                        <tr>
                          <td style="text-align: right;">
                            <button class="btn btn-primary btn-sm">Update Visit <?php echo $visit->visit_no; ?> Remarks</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </form>
                <?php } else { ?>
                  <div id="<?php echo $visit->visit_no; ?>_p">
                    <?php if ($visit->remarks) { ?>
                      <?php echo $visit->remarks; ?>
                    <?php } else { ?>
                      <?php echo "Visit remarks pending...."; ?>
                    <?php } ?>
                  </div>
                <?php  } ?>

              </div>

              <br />
            <?php
            }
            ?>



            <!-- <form action="<?php echo site_url(ADMIN_DIR . "reception/upload_attachment"); ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" value="<?php echo $invoice_id; ?>" name="invoice_id" />
              <input type="hidden" value="<?php echo $visit->visit_id; ?>" name="visit_id" />
              <table class="table">
                <tr>
                  <td>
                    Attachment: <input required type="file" style="width: 120px;" name="attchment_file" value="" />
                  </td>
                  <td>
                    Attachment Name: <br />
                    <input required type="text" name="attachment_name" value="" />
                  </td>
                  <td width="500px">
                    Attachment Detail:<br />
                    <textarea rows="1" name="attachment_detail" style="width: 100%;"></textarea>
                  </td>
                  <td>
                    Upload Attachment<br />
                    <input class="btn btn-primary btn-small" type="submit" name="Upload Attachment" value="Upload Attachment" />
                  </td>

                </tr>
              </table>
            </form> -->
          <?php } ?>

        </div>
        <div style="text-align: center;">
          <form onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo site_url(ADMIN_DIR . "reception/add_visit"); ?>" method="post">
            <input type="hidden" value="<?php echo $invoice_detail->patient_id; ?>" name="patient_id" />
            <input type="hidden" value="<?php echo $invoice_detail->invoice_id; ?>" name="history_id" />
            <input class="btn btn-primary" type="submit" name="Add New Visit" value="Add New Visit" />
          </form>
        </div>
      </div>
    </div>
    <script src="//cdn.ckeditor.com/4.20.1/basic/ckeditor.js"></script>
    <script>
      // CKEDITOR.replace('dr_prescriptions');
      // CKEDITOR.config.height = 150;

      // function add_medicine(id) {

      //   value = $('#medicine_' + id).val();
      //   CKEDITOR.instances['dr_prescriptions'].insertHtml(value);

      // }
    </script>
  </div>

</div>

</section>

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


    <a class="btn btn-warning btn-sm" href="<?php echo site_url(ADMIN_DIR . "reception/index"); ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Dashboard</a>




    <a class="btn btn-info btn-sm" href="<?php echo site_url(ADMIN_DIR . "reception/print_patient_report/" . $invoice_detail->invoice_id); ?>" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print Report</a>

    <?php if ($invoice_detail->status == 3) {
      if ($invoice_detail->category_id != 5) {

        $query = "SELECT test_category FROM test_categories WHERE test_category_id= '" . $invoice_detail->category_id . "'";
        $Doctor_name = $this->db->query($query)->result()[0]->test_category;
        // echo " - " . $invoice_detail->today_count;
      } else {
        $query = "SELECT test_group_name FROM test_groups WHERE test_group_id = '" . $invoice_detail->opd_doctor . "'";
        $opd_doctor = $this->db->query($query)->result()[0]->test_group_name;
        $Doctor_name = $opd_doctor;
        //echo "" . $opd_doctor . ' - ';
        //echo  $invoice_detail->today_count;
      }
    ?>

      <form style="display: inline;" onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo site_url(ADMIN_DIR . "reception/complete_and_forward/$invoice_id"); ?>" method="post">
        <button class="btn btn-danger btn-sm"> <i class="fa fa-forward" aria-hidden="true"></i> Again Forward to <?php echo $Doctor_name ?> Online</button>
      </form>
    <?php } ?>

  </section>


</div>

</div>

<script>
  function autoheight(x) {
    x.style.height = "150px";
    x.style.height = (15 + x.scrollHeight) + "px";
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
        <div style="width: 100%;">
          <img id="image_dispaly" src="" width="100%" />
        </div>
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