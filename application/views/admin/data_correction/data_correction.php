<!-- PAGE HEADER-->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->
            <ul class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li><?php echo $title; ?></li>
            </ul>
            <!-- /BREADCRUMBS -->
            <div class="row">

                <div class="col-md-6">
                    <div class="clearfix">
                        <h3 class="content-title pull-left"><?php echo $title; ?></h3>
                    </div>
                    <div class="description"><?php echo $title; ?></div>
                </div>

                <div class="col-md-6">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR . "tests/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR . "tests/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-file"></i>Today Reception Receipt</h4>
            </div>
            <div class="box-body" style="font-size: 12px !important;">

                <?php if ($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")) {

                    $type = "";
                    if ($this->session->flashdata("msg_success")) {
                        $type = "success";
                        $msg = $this->session->flashdata("msg_success");
                    } elseif ($this->session->flashdata("msg_error")) {
                        $type = "danger";
                        $msg = $this->session->flashdata("msg_error");
                    } else {
                        $type = "info";
                        $msg = $this->session->flashdata("msg");
                    }
                    echo '<div class="alert alert-' . $type . '" role="alert">' . $msg . '</div>';
                ?>



                <?php }  ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice No</th>
                            <th>Category</th>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Mobile</th>

                            <th>Total</th>
                            <th>Discount</th>
                            <th>Rs:</th>
                            <th>Cancellation</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach ($all_tests as $test) {
                        $color = '';
                        if ($test->is_deleted == 1) {
                            $color = "#ffe8e7";
                        }
                    ?>
                        <tr style="background-color: <?php echo $color; ?>;">
                            <td><?php echo $test->invoice_id; ?> </td>
                            <td><?php echo $test->invoice_id; ?></td>
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
                            <td><?php echo $test->price; ?></td>
                            <td><?php echo $test->discount; ?>
                                <?php if ($test->discount) { ?>
                                    <?php
                                    $query = "SELECT * FROM discount_types WHERE discount_type_id='" . $test->discount_type_id . "'";
                                    $discount_type = $this->db->query($query)->row();
                                    echo "<br />";
                                    echo "Type: " . $discount_type->discount_type;
                                    echo "<br />";
                                    echo "Regered By:" . $test->discount_ref_by;
                                    ?>
                                <?php } ?>
                            </td>
                            <td><?php echo $test->total_price; ?>

                            </td>
                            <td>
                                <?php if ($test->is_deleted != 0) { ?>
                                    <?php echo $test->cancel_reason; ?>
                                    <br />
                                    Detail: <?php echo $test->cancel_reason_detail; ?>
                                <?php } ?>
                            </td>

                            <td>
                                <?php if ($test->is_deleted == 0) { ?>
                                    <a class="btn btn-danger btn-sm" href="javascript:open_cancelation_modal('<?php echo $test->invoice_id; ?>')">Cancel Receipt</a>
                                <?php } else { ?>
                                    <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure? you want to undo?')" href=" <?php echo site_url(ADMIN_DIR . "data_correction/undo_cancelation/" . $test->invoice_id); ?>"> <i class="fa fa-undo"></i> Undo Cancelation</a>
                                <?php } ?>
                                <a class="btn btn-success btn-sm" href="javascript:open_discount_modal('<?php echo $test->invoice_id; ?>')">Discount</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

            </div>
        </div>
    </div>
</div>
<div id="c_model" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="$('#c_model').modal('hide');">&times;</button>
                <h4 class="modal-title" id="c_model_title">Title</h4>
            </div>
            <div class="modal-body" id="" style="text-align:center !important">
                <form method="post" action="<?php echo site_url(ADMIN_DIR . "data_correction/cancel_receipt"); ?>">
                    <input type="hidden" name="invoice_id" value="" id="c_invoice_id" />
                    <table class="table">
                        <tbody>

                            <tr>
                                <td>
                                    Cancellation Reasons Type</td>
                                <td>
                                    <select class="form-control" required="required" name="cancel_reason">
                                        <option value="">Cancellation Reasons</option>
                                        <option value="patient_cancelled">Patient Cancelled</option>
                                        <option value="fault_entry">Fault Entery</option>
                                        <option value="opd_doctor_return">OPD Doctor Return</option>
                                        <option value="advance_booking_cancellation">Advance Booking Cancellation</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Reason Detail :</td>
                                <td>
                                    <input class="form-control" required="required" type="text" name="cancel_reason_detail" />

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Invoice Token No:</td>
                                <td>
                                    <input class="form-control" required="required" type="text" name="receipt_token" />

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="btn btn-danger" type="submit" name="Cancel Receipt" value="Cancel Receipt" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer" style="display: none">
                <!-- <button type="submit" class="btn btn-success">Save</button> -->
            </div>
        </div>
    </div>
</div>
<div id="discount_model" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="$('#discount_model').modal('hide');">&times;</button>
                <h4 class="modal-title" id="discount_model_title">Title</h4>
            </div>
            <div class="modal-body" id="" style="text-align:center !important">
                <form action="<?php echo site_url(ADMIN_DIR . "data_correction/add_discount") ?>" method="post">
                    <input type="hidden" name="invoice_id" value="" id="invoice_id" />
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Discount</td>
                                <td>
                                    <input required type="number" name="discount" value="0" id="discount" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Discount Type:</td>
                                <td>
                                    <select required class="form-control" name="discount_type_id" id="discount_type_id">
                                        <option value="">Select Discount Type</option>
                                        <?php $query = "SELECT * FROM discount_types";
                                        $discount_types = $this->db->query($query)->result();
                                        foreach ($discount_types as $discount_type) { ?>
                                            <option value="<?php echo $discount_type->discount_type_id; ?>"><?php echo $discount_type->discount_type; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    On Reference By :</td>
                                <td> <input required class="form-control" type="text" name="discount_ref_by" id="discount_ref_by" value="">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="btn btn-danger" type="submit" name="Add Discount" value="Add Discount" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer" style="display: none">
                <!-- <button type="submit" class="btn btn-success">Save</button> -->
            </div>
        </div>
    </div>
</div>
<script>
    function open_discount_modal(invoice_id) {

        $('#invoice_id').val(invoice_id);
        $('#discount_model_title').html('Discount');
        $('#discount_model').modal('show');
    }

    function open_cancelation_modal(invoice_id) {

        $('#c_invoice_id').val(invoice_id);
        $('#c_model_title').html('Invoice Cancelation');
        $('#c_model').modal('show');
    }

    function add_test_unit(test_id) {
        test_unit = $('#test_unit_' + test_id).val();
        $.ajax({
            type: "POST",
            url: '<?php echo site_url(ADMIN_DIR . "test_groups/add_test_unit"); ?>',
            data: {
                test_unit: test_unit,
                test_id,
                test_id
            }
        }).done(function(data) {
            //$('#edit_student_info_body').html(data);
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#testTable').DataTable({
            "pageLength": 500
        });
    });
</script>