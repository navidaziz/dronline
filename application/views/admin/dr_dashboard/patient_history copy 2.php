<div class="row">
  <div class="col-sm-12">
    <div class="page-header" style="min-height: 10px;">
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
        <?php
        $query = "SELECT COUNT(*) as total FROM invoices WHERE patient_id = '" . $invoice_detail->patient_id . "'";
        $total_appointments = $this->db->query($query)->row()->total;
        if ($total_appointments == 1) { ?>
          <h3 style="text-align: center;"><strong>Visit Type: </strong> Initial Visit</h3>
        <?php } else { ?>
          <h3 style="text-align: center;"><strong>Visit Type: </strong> Followup</h3>
        <?php } ?>

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
                      <table class="table">
                        <?php if ($patient_tests_group->test_group_id == 1) { ?>

                          <?php foreach ($patient_tests_group->patient_tests as $patient_test) { ?>
                            <tr>
                              <th style="width: 200px;"><?php echo $patient_test->test_name; ?></th>
                              <td>
                                <?php echo $patient_test->test_result; ?>
                                <?php echo $patient_test->result_suffix; ?>
                                <small> <?php echo $patient_test->unit; ?> </small>
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

    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Patient Visits</h4>
      </div>
      <div class="box-body">
        <div>
          <!-- <div class="col-md-6">
                  <ul style="list-style: none;">
                  <?php $query = "SELECT * FROM medicines";
                  $medicines = $this->db->query($query)->result();
                  foreach ($medicines as $medicine) { ?>
                      <li style="cursor: pointer;" onclick="add_medicine('<?php echo $medicine->medicine_id; ?>')"><strong><?php echo $medicine->medicine_name; ?></strong>
                        <small><?php echo $medicine->medicine_detail; ?></small>
                        <?php $value = "<p><strong>" . $medicine->medicine_name . "</strong> ( " . $medicine->medicine_detail . " )</p><br />"; ?>
                        <input id="medicine_<?php echo $medicine->medicine_id; ?>" type="hidden" value="<?php echo $value; ?>" />
                        <span style="margin-left:10px ;"></span>
                      </li>
                    <?php } ?>
                  </ul>
                </div> -->
          <?php
          $query = "SELECT patient_visits.*, users.user_title FROM patient_visits 
          INNER JOIN users ON (users.user_id = patient_visits.created_by)
                    WHERE patient_id = '" . $invoice_detail->patient_id . "'";
          $visits = $this->db->query($query)->result();
          $visit_id = 0;
          foreach ($visits as $visit) { ?>
            <div style="border: 1px solid lightgray; border-radius:5px; padding:5px;">
              <h4>Visit No. <?php echo $visit->visit_no; ?>
                <small class="pull-right">
                  Dated: <?php echo date('d M, Y', strtotime($visit->created_date)); ?>
                </small>
              </h4>
              <hr />


              <?php if ($visit->status == 1) { ?>
                <form onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo site_url(ADMIN_DIR . "dr_dashboard/update_visit"); ?>" method="post">
                  <input type="hidden" value="<?php echo $visit->visit_id; ?>" name="visit_id" />
                  <input type="hidden" value="<?php echo $invoice_detail->patient_id; ?>" name="patient_id" />
                  <input type="hidden" value="<?php echo $invoice_detail->invoice_id; ?>" name="history_id" />
                  <table class="table">
                    <tbody>
                      <tr>
                        <td><textarea name="dr_prescriptions" id="dr_prescriptions" onkeyup="autoheight(this)" style="width: 100%; height:150px; border-radius: 9px;"><?php echo $visit->remarks; ?></textarea></td>
                      </tr>
                      <tr>
                        <td style="text-align: right;">
                          <button class="btn btn-primary btn-sm">Update Visit <?php echo $visit->visit_no; ?> Detail</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
              <?php } ?>
              <?php if ($visit->status == 0) { ?>
                <?php echo $visit->remarks; ?>
              <?php } ?>
              <p style="text-align: right;">Created By: <?php echo $visit->user_title; ?></p>
            </div>
            <br />
          <?php }  ?>

          <h3>Attachements</h3>
          <div class="row">
            <?php
            $query = "SELECT * FROM patient_attachments WHERE invoice_id = '" . $invoice_id . "'";
            $attachments = $this->db->query($query)->result();
            $count = 1;
            foreach ($attachments as $attachment) {
            ?>
              <div class="col-md-3">
                <?php echo $count . ": File Name: " . $attachment->name . "<br />
                File Detail: " . $attachment->detail . "<br />" ?>
                <a href="javascript:view_image('<?php echo $attachment->id; ?>')">
                  <input type="hidden" id="image_<?php echo $attachment->id; ?>" value="<?php echo $attachment->file ?>" />
                  <input type="hidden" id="name_<?php echo $attachment->id; ?>" value="<?php echo $attachment->name ?>" />
                  <input type="hidden" id="detail_<?php echo $attachment->id; ?>" value="<?php echo $attachment->detail ?>" />
                  <?php echo file_type(base_url("assets/uploads/reception/" . $attachment->file), false); ?> </a>
                <br />
                <small> <a href="<?php echo site_url(ADMIN_DIR . "reception/delete_attachement/$invoice_id/" . $attachment->id); ?>" onclick="return confirm('Are you sure? you want to remove ?')">Remove Attachment</a> </small>
              </div>
            <?php
              $count++;
            } ?>
          </div>


          <form action="<?php echo site_url(ADMIN_DIR . "dr_dashboard/upload_attachment"); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $invoice_id; ?>" name="invoice_id" />
            <input type="hidden" value="<?php echo $visit->visit_id; ?>" name="visit_id" />
            <table class="table">
              <tr>
                <td>
                  Attachment: <input required type="file" name="attchment_file" value="" />
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
        <div style="text-align: center;">
          <form onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo site_url(ADMIN_DIR . "dr_dashboard/add_visit"); ?>" method="post">
            <input type="hidden" value="<?php echo $invoice_detail->patient_id; ?>" name="patient_id" />
            <input type="hidden" value="<?php echo $invoice_detail->invoice_id; ?>" name="history_id" />
            <input class="btn btn-primary" type="submit" name="Add New Visit" value="Add New Visit" />
          </form>
        </div>
      </div>
    </div>


    <script src="//cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
      CKEDITOR.replace('dr_prescriptions');
      CKEDITOR.config.height = 300;

      function add_medicine(id) {

        value = $('#medicine_' + id).val();
        CKEDITOR.instances['dr_prescriptions'].insertHtml(value);

      }
    </script>

    <?php if ($invoice_detail->status == 3) { ?>
      <!-- <h4 class="alert alert-success">Case is completed</h4> -->
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

</section>


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