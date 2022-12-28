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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR . "suppliers/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR . "suppliers/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

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

                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th><?php echo $this->lang->line('supplier_name'); ?></th>
                                <th><?php echo $this->lang->line('supplier_contact_no'); ?></th>
                                <th><?php echo $this->lang->line('company_name'); ?></th>
                                <th><?php echo $this->lang->line('account_number'); ?></th>
                                <th>Total Amount</th>
                                <th>Print Invoices</th>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <th><?php echo $this->lang->line('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($suppliers as $supplier) : ?>

                                <tr>


                                    <td>
                                        <?php echo $supplier->supplier_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $supplier->supplier_contact_no; ?>
                                    </td>
                                    <td>
                                        <?php echo $supplier->company_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $supplier->account_number; ?>
                                    </td>
                                    <td><?php
                                        $query = "SELECT  ROUND(SUM( `inventory`.`item_cost_price`*`inventory`.`inventory_transaction`),2) AS total 
									        FROM   `inventory` WHERE `inventory`.`supplier_id`='" . $supplier->supplier_id . "';";
                                        $total_amount = $this->db->query($query)->result()[0]->total;
                                        echo $total_amount; ?> </td>
                                    <td><a href="<?php echo site_url(ADMIN_DIR . "suppliers/print_supplier_invoices/" . $supplier->supplier_id); ?>" target="_new">
                                            <span class="fa fa-print"></span>
                                            Print </a>
                                    </td>
                                    <td>
                                        <?php echo status($supplier->status,  $this->lang); ?>
                                        <?php

                                        //set uri segment
                                        if (!$this->uri->segment(4)) {
                                            $page = 0;
                                        } else {
                                            $page = $this->uri->segment(4);
                                        }

                                        if ($supplier->status == 0) {
                                            echo "<a href='" . site_url(ADMIN_DIR . "suppliers/publish/" . $supplier->supplier_id . "/" . $page) . "'> &nbsp;" . $this->lang->line('Publish') . "</a>";
                                        } elseif ($supplier->status == 1) {
                                            echo "<a href='" . site_url(ADMIN_DIR . "suppliers/draft/" . $supplier->supplier_id . "/" . $page) . "'> &nbsp;" . $this->lang->line('Draft') . "</a>";
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR . "suppliers/view_supplier/" . $supplier->supplier_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                        <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR . "suppliers/edit/" . $supplier->supplier_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                        <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR . "suppliers/trash/" . $supplier->supplier_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
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