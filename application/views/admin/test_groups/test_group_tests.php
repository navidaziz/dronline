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

                    <table class="table table-bordered" id="testG roupsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th><?php echo $this->lang->line('test_group_name'); ?></th>
                                <th><?php echo $this->lang->line('test_price'); ?></th>
                                <th><?php echo $this->lang->line('test_time'); ?></th>
                                <!-- <th><?php echo $this->lang->line('Order'); ?></th><th><?php echo $this->lang->line('Status'); ?></th>
<th><?php echo $this->lang->line('Action'); ?></th> -->
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
                                    <!-- <td>
                                  <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR . "test_groups/up/" . $test_group->test_group_id . "/" . $this->uri->segment(3)); ?>"><i class="fa fa-arrow-up"></i> </a>
                                  <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR . "test_groups/down/" . $test_group->test_group_id . "/" . $this->uri->segment(3)); ?>"><i class="fa fa-arrow-down"></i></a>
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
                            </td> -->
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <?php $query = "SELECT
                    `test_group_tests`.`test_group_id`
                    , `test_group_tests`.`test_id`
                    , `tests`.`test_name`
                    , `tests`.`test_time`
                    , `tests`.`unit`
                    , `tests`.`test_price`
                    , `tests`.`test_description`
                    , `tests`.`normal_values`
                    , `test_group_tests`.`test_group_test_id`
                    , `test_types`.`test_type` 
                FROM
                `tests`, `test_group_tests`, `test_types`  
                WHERE `tests`.`test_id` = `test_group_tests`.`test_id`
                AND `test_group_tests`.`test_group_id` ='" . $test_group->test_group_id . "' 
                AND `test_types`.`test_type_id` = `tests`.`test_type_id` 
                ORDER BY `test_group_tests`.`order`
                ";

                                        $test_group_tests = $this->db->query($query)->result();

                                        ?>
                                        <table class="table table-bordered">
                                            <thead>

                                                <tr>
                                                    <th>#</th>
                                                    <th><?php echo $this->lang->line('test_name'); ?></th>
                                                    <th>Unit</th>
                                                    <th>Normal Value</th>
                                                    <th>Test Type</th>
                                                    <!-- <th><?php echo $this->lang->line('Order'); ?></th>
                        <th><?php echo $this->lang->line('Action'); ?></th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 1;
                                                foreach ($test_group_tests as $test_group_test) : ?>

                                                    <tr>
                                                        <td><?php echo $count++; ?></td>
                                                        <td> <?php echo $test_group_test->test_name; ?> </td>
                                                        <td>
                                                            <input onkeyup="add_test_unit('<?php echo $test_group_test->test_id; ?>')" type="text" value="<?php echo $test_group_test->unit; ?>" name="test_unit" id="test_unit_<?php echo $test_group_test->test_id; ?>" />
                                                        </td>
                                                        <td> <?php echo $test_group_test->normal_values; ?> </td>
                                                        <td><?php echo $test_group_test->test_type; ?></td>
                                                        <!-- <td> 
                         <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR . "test_groups/up_test/" . $test_group_test->test_group_test_id . "/" . $test_groups[0]->test_group_id); ?>"><i class="fa fa-arrow-up"></i> </a>
                         <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR . "test_groups/down_test/" . $test_group_test->test_group_test_id . "/" . $test_groups[0]->test_group_id); ?>"><i class="fa fa-arrow-down"></i></a>
                         </td>
                         <td>
                         <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR . "test_groups/delete_test/" . $test_group_test->test_group_test_id . "/" . $test_groups[0]->test_group_id); ?>"><i class="fa fa-trash-o"></i></a>
                         </td> -->
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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