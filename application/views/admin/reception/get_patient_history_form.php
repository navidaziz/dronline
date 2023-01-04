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
          <a href="<?php echo site_url(ADMIN_DIR . "reception"); ?>"><?php echo $this->lang->line('Home'); ?></a>
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
    <div class="box border blue" id="messenger">
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
        <strong>
          <?php
          $created_by = $invoice_detail->created_by;
          $query = "SELECT user_title FROM users WHERE user_id = '" . $created_by . "'";
          echo  $user_title = $this->db->query($query)->row()->user_title;
          ?>
        </strong>


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
        <p style="text-align:center">
          <strong>Case Status:</strong> <?php
                                        if ($invoice_detail->status == 1) {
                                          echo "<span class='label label-primary label-sm'>New</span>";
                                        };
                                        if ($invoice_detail->status == 2) {
                                          echo "<span class='label label-danger label-sm'>Forwarded</span>";
                                        };
                                        ?>
        </p>

      </div>
    </div>

    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-flask"></i>Test List</h4>
      </div>
      <div class="box-body">
        <div class="row" style="font-size: 12px !important;">
          <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/jquery.dataTables.css") ?>">

          <script type="text/javascript" charset="utf8" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/jquery.dataTables.js") ?>"></script>
          <script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/dataTables.buttons.min.js") ?>"></script>
          <script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/jszip.min.js") ?>"></script>
          <script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/pdfmake.min.js") ?>"></script>
          <script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/vfs_fonts.js") ?>"></script>
          <script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/buttons.html5.min.js") ?>"></script>
          <script type="text/javascript" language="javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "other_files/buttons.print.min.js") ?>"></script>

          <div class="col-md-12">
            <form action="<?php echo site_url(ADMIN_DIR . "reception/create_patient_history"); ?>" method="post">
              <input type="hidden" name="invoice_id" value="<?php echo $invoice_detail->invoice_id; ?>" />
              <table id="testGroupsTable" class="display">
                <thead>
                  <tr>
                    <th>#</th>
                    <!-- <th>G_ID</th> -->
                    <th>Test(s)</th>
                    <!-- <th>Time</th> -->
                    <!-- <th>Price</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $where = "`test_groups`.`status` IN (1) AND category_id!=5";
                  if ($patient_test_ids) {
                    $where .= " AND test_group_id NOT IN (" . $patient_test_ids . ") ORDER BY  test_group_name ASC";
                  }
                  $test_groups = $this->test_group_model->get_test_group_list($where, false);

                  foreach ($test_groups as $test_group) { ?>
                    <tr>
                      <td>
                        <input class="test_list" style="display: inline;" name="test_group_id[]" id="TG_<?php echo $test_group->test_group_id; ?>" onclick="set_price('<?php echo $test_group->test_group_id; ?>', '<?php echo $test_group->test_group_name; ?>', '<?php echo $test_group->test_price; ?>', '<?php echo $test_group->test_time; ?>', '0')" type="checkbox" value="<?php echo $test_group->test_group_id; ?>" />
                      </td>
                      <!-- <td><?php echo $test_group->test_group_id; ?></td> -->
                      <td><strong style="margin-left:2px;">
                          <?php echo $test_group->test_group_name; ?>
                        </strong></td>

                      <!-- <td><?php
                                if ($test_group->category_id != 5) {
                                  echo $test_group->test_time . " min";
                                }
                                ?></td> -->
                      <!-- <td><?php echo $test_group->test_price; ?> Rs.</td> -->
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <p style="text-align: center;">
                <input class="btn btn-danger btn-sm" type="submit" value="Add Patient Test" name="Add Patient Test" />
              </p>
            </form>
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
  <div class="col-md-9">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Patient History and Tests Detail</h4>
      </div>
      <div class="box-body">
        <div class="row">
          <?php foreach ($patient_tests_groups as $patient_tests_group) { ?>
            <?php if ($patient_tests_group->test_group_id == 1) { ?>
              <div class="col-md-12">
                <div style="background-color: #F4F4F4; padding:5px; border-radius:5px; margin-bottom:5px">
                  <form action="<?php echo site_url(ADMIN_DIR . "reception/update_test_data/" . $invoice_id); ?>" method="post">
                    <h4><?php echo $patient_tests_group->test_group_name; ?>
                    </h4>
                    <table class="table table-bordered" style="text-align: left; font-size:12px">

                      <?php
                      $count = 1;
                      foreach ($patient_tests_group->patient_tests as $patient_test) { ?>
                        <tr>
                          <th style="width: 200px;"><?php echo $patient_test->test_name; ?></th>
                          <td>
                            <textarea class="test_valu e_input" style="width: 100%;" onkeyup="update_test_value('<?php echo $patient_test->patient_test_id; ?>')" type="text" id="test_<?php echo $patient_test->patient_test_id; ?>_value" name="test_values[<?php echo $patient_test->patient_test_id; ?>]" rows="2"><?php echo $patient_test->test_result; ?></textarea>
                          </td>
                        </tr>
                      <?php } ?>
                    </table>
                    <p style="text-align: center; padding:5px">
                      <input class="btn btn-primary btn-small" type="submit" name="Update <?php echo $patient_tests_group->test_group_name; ?> Data" value="Update <?php echo $patient_tests_group->test_group_name; ?> Data" />
                    </p>
                  </form>
                </div>
              </div>
            <?php } else { ?>
              <div class="col-md-6">
                <div style="background-color: #F4F4F4; padding:5px; border-radius:5px; margin-bottom:5px">
                  <form action="<?php echo site_url(ADMIN_DIR . "reception/update_test_data/" . $invoice_id); ?>" method="post">
                    <h4><?php echo $patient_tests_group->test_group_name; ?>
                      <small>
                        <a class="pull-right" onclick="return confirm('Are you sure? you want to remove ?')" href="<?php echo site_url(ADMIN_DIR . "reception/delete_patient_history/$invoice_detail->invoice_id/$patient_tests_group->test_group_id") ?>">Remove</a>
                      </small>
                    </h4>
                    <table class="table table-bordered" style="text-align: left; font-size:12px">
                      <tr>
                        <th>#</th>
                        <th>Test(s)</th>
                        <th>Test Result</th>
                        <th>Unit</th>
                        <th>Normal(s)</th>
                        <!-- <th>Remarks</th> -->
                      </tr>
                      <?php
                      $count = 1;
                      foreach ($patient_tests_group->patient_tests as $patient_test) { ?>
                        <tr>
                          <td><?php echo $count++; ?></td>
                          <td><?php echo $patient_test->test_name; ?></td>
                          <td><input class="test_value_input" onkeyup="update_test_value('<?php echo $patient_test->patient_test_id; ?>')" type="text" id="test_<?php echo $patient_test->patient_test_id; ?>_value" value="<?php echo $patient_test->test_result; ?>" name="test_values[<?php echo $patient_test->patient_test_id; ?>]" />
                            <strong><?php echo $patient_test->result_suffix; ?></strong>
                          </td>
                          <td><?php echo $patient_test->unit; ?></td>
                          <td><?php echo $patient_test->test_normal_value; ?></td>
                          <!-- <td><input type="text" onkeyup="update_test_remarks('<?php echo $patient_test->patient_test_id; ?>')" id="test_<?php echo $patient_test->patient_test_id; ?>_remark" value="<?php echo $patient_test->remarks; ?>" /></td> -->
                        </tr>
                      <?php } ?>
                    </table>
                    <p style="text-align: center; padding:5px">
                      <input class="btn btn-primary btn-small" type="submit" name="Update <?php echo $patient_tests_group->test_group_name; ?> Data" value="Update <?php echo $patient_tests_group->test_group_name; ?> Data" />
                    </p>
                  </form>
                </div>
              </div>
            <?php } ?>
          <?php  } ?>
        </div>
        <br />
        <form action="<?php echo site_url(ADMIN_DIR . "reception/update_remark/" . $invoice_id); ?>" method="post">


          <div><strong>Remarks:</strong>
            <textarea name="test_remarks" id="test_remarks" class="form-control" style="margin-bottom: 5px;"><?php echo $invoice->remarks; ?></textarea>
          </div>
          <input type="hidden" value="<?php echo $invoice_id; ?>" name="invoice_id" />
          <input class="btn btn-primary btn-small" type="submit" name="Update Remarks" value="Update Remarks" />
        </form>
        <div>

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
                  <?php echo file_type(base_url("assets/uploads/reception/" . $attachment->file), true); ?> </a>
                <br />
                <small> <a href="<?php echo site_url(ADMIN_DIR . "reception/delete_attachement/$invoice_id/" . $attachment->id); ?>" onclick="return confirm('Are you sure? you want to remove ?')">Remove Attachment</a> </small>
              </div>
            <?php
              $count++;
            } ?>
          </div>


          <form action="<?php echo site_url(ADMIN_DIR . "reception/upload_attachment"); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $invoice_id; ?>" name="invoice_id" />
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
          <div style="text-align: center;">

            <?php if ($invoice_detail->status == 2) { ?>
              <h4 class="alert alert-danger">Case Forwarded to <?php echo $Doctor_name ?></h4>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
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
    <a class="btn btn-warning btn-sm" href="<?php echo site_url(ADMIN_DIR . "reception/index"); ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Dashboard</a>
    <?php if ($invoice_detail->status == 3) { ?>
      <a class="btn btn-info btn-sm" href="<?php echo site_url(ADMIN_DIR . "dr_dashboard/print_patient_report/" . $invoice_detail->invoice_id); ?>"><i class="fa fa-print" aria-hidden="true"></i> Print Report</a>
    <?php } ?>
    <?php
    if ($invoice_detail->status == 1) { ?>

      <form style="display: inline;" onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo site_url(ADMIN_DIR . "reception/complete_and_forward/$invoice_id"); ?>" method="post">
        <button class="btn btn-danger btn-sm"> <i class="fa fa-forward" aria-hidden="true"></i> Complete and Forward to <?php echo $Doctor_name ?> Online</button>
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