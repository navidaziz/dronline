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
				<li>
					<i class="fa fa-table"></i>
					<a href="<?php echo site_url(ADMIN_DIR . "suppliers/view/"); ?>"><?php echo $this->lang->line('Suppliers'); ?></a>
				</li>
				<li><?php echo $title; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
			<div class="row">

				<div class="col-md-6">
					<div class="clearfix">
						<h3 class="content-title pull-left"><?php echo $title; ?></h3>
					</div>
					<div class="description"><?php echo $detail; ?></div>
				</div>

				<div class="col-md-6">
					<div class="pull-right">

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
	<div class="col-md-6">
		<div class="box border blue" id="messenger">
			<div class="box-title">
				<h4><i class="fa fa-bell"></i> <?php echo $title; ?> Stock In Invoices</h4>
			</div>
			<div class="box-body">

				<div class="table-responsive">
					<form method="post" action="<?php echo site_url(ADMIN_DIR . "suppliers/add_supplier_invoce") ?>">
						<input type="hidden" name="return_receipt" value="0" />
						<table>
							<td>Invoice Number: <input type="text" name="supplier_invoice_number" />
								<input type="hidden" name="supplier_id" value="<?php echo $suppliers[0]->supplier_id; ?>" />
								<?php echo form_error("supplier_invoice_number", "<p class=\"text-danger\">", "</p>"); ?>
							</td>
							<td>Invoice Date: <input type="date" name="invoice_date" />
								<?php echo form_error("invoice_date", "<p class=\"text-danger\">", "</p>"); ?>

							</td>
							<td>
								Stock In Invoice
								<input type="submit" name="Save" value="Add Invoice" />
							</td>
						</table>
					</form>
					<hr />

					<h4><?php echo $title; ?> Stock In Invoices List</h4>
					</h4>
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Invoice Number</th>
								<th>Invoice Date</th>
								<th>Total Amount</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							foreach ($suppliers_invoices as $suppliers_invoice) : ?>


								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $suppliers_invoice->supplier_invoice_number; ?> </td>
									<td><?php echo date('d M, Y', strtotime($suppliers_invoice->invoice_date)); ?> </td>
									<td><?php
										$query = "SELECT  ROUND(SUM( `inventory`.`item_cost_price`*`inventory`.`inventory_transaction`),2) AS total 
									        FROM   `inventory` WHERE `inventory`.`supplier_invoice_id`='" . $suppliers_invoice->supplier_invoice_id . "';";
										$total_amount = $this->db->query($query)->result()[0]->total;
										echo $total_amount; ?> </td>
									<td><a href="<?php echo site_url(ADMIN_DIR . "suppliers/supplier_invoice_view/" . $suppliers_invoice->supplier_id . "/" . $suppliers_invoice->supplier_invoice_id);  ?>">View Invoice Detail</a></td>
									<td><a href="<?php echo site_url(ADMIN_DIR . "suppliers/print_supplier_item_lists/" . $suppliers_invoice->supplier_id . "/" . $suppliers_invoice->supplier_invoice_id); ?>" target="_new">
											<span class="fa fa-print"></span>
											Print </a>
									</td>
								</tr>


							<?php endforeach; ?>
						</tbody>
					</table>




				</div>


			</div>

		</div>
	</div>


	<div class="col-md-6">
		<div class="box border blue" id="messenger">
			<div class="box-title">
				<h4><i class="fa fa-bell"></i> <?php echo $title; ?> Return Items</h4>
			</div>
			<div class="box-body">

				<div class="table-responsive">

					<form method="post" action="<?php echo site_url(ADMIN_DIR . "suppliers/add_supplier_invoce") ?>">
						<input type="hidden" name="return_receipt" value="1" />
						<table>
							<td>Invoice Number: <input type="text" name="supplier_invoice_number" />
								<input type="hidden" name="supplier_id" value="<?php echo $suppliers[0]->supplier_id; ?>" />
								<?php echo form_error("supplier_invoice_number", "<p class=\"text-danger\">", "</p>"); ?>
							</td>
							<td>Invoice Date: <input type="date" name="invoice_date" />
								<?php echo form_error("invoice_date", "<p class=\"text-danger\">", "</p>"); ?>

							</td>
							<td>
								Stock In Invoice
								<input type="submit" name="Save" value="Add Invoice" />
							</td>
						</table>
					</form>
					<hr />

					<h4><?php echo $title; ?> Return List</h4>
					</h4>
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Items Return Number</th>
								<th>Return Date</th>
								<th>Total Amount</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							foreach ($suppliers_returns as $suppliers_invoice) : ?>


								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $suppliers_invoice->supplier_invoice_number; ?> </td>
									<td><?php echo $suppliers_invoice->invoice_date; ?> </td>
									<td><?php
										$query = "SELECT  ROUND(SUM( `inventory`.`item_cost_price`*`inventory`.`inventory_transaction`),2) AS total 
									        FROM   `inventory` WHERE `inventory`.`supplier_invoice_id`='" . $suppliers_invoice->supplier_invoice_id . "';";
										$total_amount = $this->db->query($query)->result()[0]->total;
										echo $total_amount; ?> </td>
									<td><a href="<?php echo site_url(ADMIN_DIR . "suppliers/supplier_return_view/" . $suppliers_invoice->supplier_id . "/" . $suppliers_invoice->supplier_invoice_id);  ?>">View Returns Detail</a></td>
									<td><a href="<?php echo site_url(ADMIN_DIR . "suppliers/print_supplier_return_item_lists/" . $suppliers_invoice->supplier_id . "/" . $suppliers_invoice->supplier_invoice_id); ?>" target="_new">
											<span class="fa fa-print"></span>
											Print </a>
									</td>

								</tr>


							<?php endforeach; ?>
						</tbody>
					</table>




				</div>


			</div>

		</div>
	</div>
	<!-- /MESSENGER -->
</div>