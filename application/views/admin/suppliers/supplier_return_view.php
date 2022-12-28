<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- PAGE HEADER-->
<script>
	function update_stock(id) {
		stock = $('#stock_' + id).val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url(ADMIN_DIR . "suppliers/update_supplier_item_stock") ?>",
			data: {
				inventory_id: id,
				stock: stock
			}
		}).done(function(data) {
			//alert(data);
			$('#stock_view_' + id).html(data);
		});

	}
</script>

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
				<li>
					<a href="<?php echo site_url(ADMIN_DIR . "suppliers/view_supplier/" . $suppliers[0]->supplier_id); ?>">
						<?php echo $title; ?>
					</a>
				</li>
				<li>Items Return Invoice-<?php echo $suppliers_invoices->supplier_invoice_number; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
			<div class="row">

				<div class="col-md-6">
					<div class="clearfix">
						<h3 class="content-title pull-left"><?php echo $title; ?> - Items Return </h3>
					</div>
					<div class="description">
						Items Return Invoice - <?php echo $suppliers_invoices->supplier_invoice_number; ?> -
						Date - <?php echo $suppliers_invoices->invoice_date; ?>
					</div>
				</div>

				<div class="col-md-6">

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
				<h4><i class="fa fa-files-o"></i> Items Return List</h4>
			</div>
			<div class="box-body">

				<div class="table-responsive">

					<h4> Items Return Invoice No: <?php echo $suppliers_invoices->supplier_invoice_number; ?>
						- Dated: <?php echo $suppliers_invoices->invoice_date; ?> Items List</h4>
					</h4>
					<script>
						function stock_in() {
							$('#stock_in').show();
							$('#stock_return').hide();
						}

						function stock_return() {
							$('#stock_in').hide();
							$('#stock_return').show();
						}

						function get_item_prices(id) {
							item_id = $('#' + id + ' option:selected').val();
							$.ajax({
								type: "POST",
								url: "<?php echo site_url(ADMIN_DIR . "suppliers/get_item_prices") ?>",
								data: {
									item_id: item_id,
								}
							}).done(function(data) {

								var data = jQuery.parseJSON(data);

								$('#cost_price1').val(data.cost_price);
								$('#unit_price1').val(data.sale_price);
								//get_user_sale_summary();

							});
						}

						function get_item_prices2(id) {
							item_id = $('#' + id + ' option:selected').val();
							$.ajax({
								type: "POST",
								url: "<?php echo site_url(ADMIN_DIR . "suppliers/get_item_prices") ?>",
								data: {
									item_id: item_id,
								}
							}).done(function(data) {

								var data = jQuery.parseJSON(data);

								$('#cost_price2').val(data.cost_price);
								$('#unit_price2').val(data.sale_price);
								//get_user_sale_summary();

							});
						}
					</script>

					<form method="post" action="<?php echo  site_url(ADMIN_DIR . "suppliers/return_item_stocks") ?>">
						<table class="table table-bordered table2" style="line-height: 0.5px;" id="stock_return">
							<input type="hidden" value="<?php echo  $suppliers[0]->supplier_id; ?>" name="supplier_id" />
							<input type="hidden" value="<?php echo  $suppliers_invoices->supplier_invoice_id; ?>" name="supplier_invoice_id" />
							<input type="hidden" name="unit_price" value="0" />
							<tr>
								<td>
									<strong>Items</strong>
									<?php
									echo form_dropdown("item_id", $items, "", "id = \"item_id2\" class=\"js-example-basic-single\" onchange=\"get_item_prices2('item_id2')\" required style=\"width:150px\"");
									?>
								</td>
								<td>
									<strong>Total Stock Return</strong>
									<input type="number" name="transaction" value="" id="transaction" class="form - control" title="Unit" placeholder="Transaction">
								</td>
								<td>
									<strong>Cost Price</strong>
									<input style="width: 80px;" type="number" step="any" id="cost_price2" name="cost_price" value="" id="cost_price" class="form - control" required="required" title="Cost Price" placeholder="Cost Price">
								</td>

								<td>
									<strong>Date</strong>
									<input type="date" name="date" value="" id="date" class="form - control" title="date" placeholder="date" />
								</td>

								<td>
									<strong>Remarks</strong>
									<input type="text" name="remarks" value="" id="remarks" class="form - control" title="remarks" placeholder="remarks" />
								</td>

								<td>
									<strong>Action</strong>
									<input class="btn btn-danger btn-sm" type="submit" name="return_stock" value="Return Stock" />
								</td>
							</tr>
						</table>
					</form>


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
					?>
						<div class="alert alert-<?php echo $type; ?> " role="alert">
							<strong>Note!</strong>
							<?php echo $msg; ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

					<?php } ?>

					<a href="<?php echo site_url(ADMIN_DIR . "suppliers/print_supplier_return_item_lists/" . $supplier_id . "/" . $supplier_invoice_id); ?>" target="_new" class="btn btn-success pull-right" style="margin: 5px;">
						<span class="fa fa-print"></span>
						Print Return Item list</a>
					<table class="table table-bordered table2">
						<thead>
							<th>#</th>
							<th>Item Name</th>
							<th>Batch Number</th>
							<th>Expiry Date</th>
							<th>Quantity</th>
							<th>Trade Price</th>
							<th>Net Amount</th>
							<!-- <th>Unit Price</th> -->
							<th>Transaction Type</th>
							<th>Remarks</th>
							<th>Created By</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php
							$count = 1;
							$net_total = 0;
							foreach ($inventories as $inventory) :
								$net_total += $inventory->item_cost_price * $inventory->inventory_transaction;
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $inventory->name; ?></td>
									<td><?php echo $inventory->batch_number; ?></td>
									<td>
										<?php if ($inventory->expiry_date) { ?>
											<?php echo date('d M, Y', strtotime($inventory->expiry_date)); ?>
										<?php } ?>
									</td>
									<td>
										<span id="stock_view_<?php echo $inventory->inventory_id; ?>">
											<?php echo $inventory->inventory_transaction; ?>
										</span>

										<!-- <input type="text" name="stock" value="<?php echo $inventory->inventory_transaction; ?>" id="stock_<?php echo $inventory->inventory_id; ?>" onkeyup="update_stock('<?php echo $inventory->inventory_id; ?>')" /> -->

									</td>
									<td><?php echo $inventory->item_cost_price; ?></td>
									<td><?php echo $inventory->item_cost_price * $inventory->inventory_transaction; ?></td>
									<!-- <td><?php echo $inventory->item_unit_price; ?></td> -->
									<td><strong><?php echo $inventory->transaction_type; ?></strong>
										<?php if ($inventory->return_date) { ?>
											<small><?php echo date('d M, Y', strtotime($inventory->return_date)); ?></small>
										<?php } ?>
									</td>
									<td><?php echo $inventory->remarks; ?></td>
									<td><?php echo $inventory->user_title; ?></td>
									<td><a href="<?php echo site_url(ADMIN_DIR . "suppliers/remove_supplier_item/" . $inventory->supplier_id . "/" . $inventory->supplier_invoice_id . "/" . $inventory->inventory_id . "/return") ?>">Remove</a></td>
								</tr>

							<?php endforeach; ?>
							<tr>
								<td colspan="6">Total</td>
								<th><?php echo $net_total; ?></th>
								<td colspan="4"></td>
							</tr>
						</tbody>
					</table>




				</div>


			</div>

		</div>
	</div>
	<!-- /MESSENGER -->
</div>
<script>
	$(document).ready(function() {
		$('.js-example-basic-single').select2();
	});
	$(document).ready(function() {
		$('.js-example-basic-single2').select2();
	});
</script>