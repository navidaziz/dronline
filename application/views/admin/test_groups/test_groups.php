<script>
    function update_test_group_order(test_group_id) {
        test_order = $('#group_order_' + test_group_id).val();

        $.ajax({
            type: "POST",
            url: "<?php echo site_url(ADMIN_DIR . "test_groups/update_test_group_order") ?>",
            data: {
                test_group_id: test_group_id,
                test_order: test_order
            }
        }).done(function(data) {
            //alert(data);
            $('#groupOrder_' + test_group_id).html(data);
        });
    }
</script>

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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR . "test_groups/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR . "test_groups/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>


<!-- PAGE MAIN CONTENT -->
<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
                <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>-->
            </div>
            <div class="box-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="testGroupsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th><?php echo $this->lang->line('test_group_name'); ?></th>
                                <th><?php echo $this->lang->line('test_price'); ?></th>
                                <th><?php echo $this->lang->line('test_time'); ?></th>
                                <th><?php echo $this->lang->line('Order'); ?></th>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <th><?php echo $this->lang->line('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($test_groups as $test_group) : ?>

                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td>
                                        <?php
                                        echo  $this->db->query("SELECT * FROM `test_categories` WHERE test_category_id='" . $test_group->category_id . "'")->result()[0]->test_category;
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo $test_group->test_group_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $test_group->test_price; ?>
                                    </td>
                                    <td>
                                        <?php echo $test_group->test_time; ?>
                                    </td>
                                    <td>
                                        <span id="groupOrder_<?php echo $test_group->test_group_id; ?>"><?php //echo $test_group->order; 
                                                                                                        ?></span>
                                        <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR . "test_groups/up/" . $test_group->test_group_id . "/" . $this->uri->segment(3)); ?>"><i class="fa fa-arrow-up"></i> </a>
                                        <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR . "test_groups/down/" . $test_group->test_group_id . "/" . $this->uri->segment(3)); ?>"><i class="fa fa-arrow-down"></i></a>
                                        <input type="hidden" onkeyup="update_test_group_order('<?php echo $test_group->test_group_id; ?>')" id="group_order_<?php echo $test_group->test_group_id; ?>" value="<?php echo $test_group->order; ?>" />
                                    </td>
                                    <td>
                                        <?php echo status($test_group->status,  $this->lang); ?>
                                        <?php

                                        //set uri segment
                                        if (!$this->uri->segment(4)) {
                                            $page = 0;
                                        } else {
                                            $page = $this->uri->segment(4);
                                        }

                                        if ($test_group->status == 0) {
                                            echo "<a href='" . site_url(ADMIN_DIR . "test_groups/publish/" . $test_group->test_group_id . "/" . $page) . "'> &nbsp;" . $this->lang->line('Publish') . "</a>";
                                        } elseif ($test_group->status == 1) {
                                            echo "<a href='" . site_url(ADMIN_DIR . "test_groups/draft/" . $test_group->test_group_id . "/" . $page) . "'> &nbsp;" . $this->lang->line('Draft') . "</a>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR . "test_groups/view_test_group/" . $test_group->test_group_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                        <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR . "test_groups/edit/" . $test_group->test_group_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                        <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR . "test_groups/trash/" . $test_group->test_group_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php echo $pagination; ?>


                </div>


            </div>

        </div>
    </div>
    <!-- /MESSENGER -->
</div>
<script>
    $(document).ready(function() {
        $('#testGroupsTable').DataTable({
            "pageLength": 200
        });
    });
</script>