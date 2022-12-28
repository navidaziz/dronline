<div class="row">
	<div class="col-sm-12">
		<div class="page-header" style="min-height: 10px !important;">
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>

					<a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
				</li>
				<li>
					<i class="fa fa-home"></i>

					<a href="<?php echo site_url(ADMIN_DIR . "sale_point/sale_point"); ?>">Sale Point</a>
				</li>


				<li>Return Point</li>
			</ul>
		</div>
	</div>
</div>



<div class="row" id="sale_summary_div">
	<div class="col-md-7">
		<div class="box border red" id="messenger">
			<div class="box-title">
				<h4><i class="fa fa-undo"></i>Return Item List</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<div class="ui-widget" style="height: 450px;">
						<table class="table">
							<tr>
								<td style="width: 100px;">
									<h5>Search Item</h5>
								</td>
								<td><input id="tags" name="search_sale_item" value="" placeholder="Search return Item" class="form-control" /></td>
							</tr>
						</table>

						<style>
							.table2>thead>tr>th,
							.table2>tbody>tr>th,
							.table2>tfoot>tr>th,
							.table2>thead>tr>td,
							.table2>tbody>tr>td,
							.table2>tfoot>tr>td {
								padding: 3px;
								line-height: 1;
								vertical-align: top;
								border-top: 1px solid #ddd;
								font-size: 14px !important;
						</style>

						<div id="item_list">
							<?php echo $user_items_list; ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="box border red" id="messenger">
			<div class="box-title">
				<h4><i class="fa fa-undo"></i>Return Summary</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<div class="ui-widget">

						<div id="item_sale_summary">
							<?php echo $items_return_summary; ?>
						</div>


						<br />
						<table class="table table-bordered">

							<tr>
								<td>Remarks</td>
								<td><input type="text" name="remarks" id="remarks" value="" class="form-control" /></td>
							</tr>
						</table>
						<table class="table table-bordered">


							<tr>
								<th>Customer Mobile No <input type="text" class="form-control" name="customer_mobile_no" id="customer_mobile_no" /></th>
								<th>Customer Name <input type="text" class="form-control" name="customer_name" id="customer_name" /></th>
								<th><button onclick="save_data()" class="btn btn-success" style="margin-top: 10px; width:100%">Return <br />Items</button>
								</th>

							</tr>


						</table>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<div class="modal fade" id="item_return_modal" tabindex="-1" role="dialog" aria-labelledby="inventory_model" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="display: inline;">Item Return</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="item_return_body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>


<script>
	function get_sale_receipts() {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url(ADMIN_DIR . "return_point/get_sale_receipts") ?>",
			data: {}
		}).done(function(data) {
			$('#item_return_body').html(data);

		});

	}

	function save_data() {

		var tax_ids = $("#tax_ids").val();
		var payment_type = "cash";
		remarks = $('#remarks').val();
		discount = 0;
		cash_amount = parseFloat($('#cash_amount').val());
		customer_name = $('#customer_name').val();
		customer_mobile_no = $('#customer_mobile_no').val();
		pay_able_total = parseFloat($('#pay_able_total').html());
		cash_back = parseFloat($('#cash_back').html());
		if (cash_amount == 0) {
			alert("Cash Amout is Zero");
			return false;
		}
		if (cash_amount < pay_able_total) {
			alert("Cash Amout is less the Payable total amount");
			return false;
		}

		$.ajax({
			type: "POST",
			url: "<?php echo site_url(ADMIN_DIR . "return_point/add_return_data") ?>",
			data: {
				payment_type: payment_type,
				remarks: remarks,
				discount: discount,
				cash_amount: cash_amount,
				customer_name: customer_name,
				customer_mobile_no: customer_mobile_no,
				pay_able_total: pay_able_total,
				cash_back: cash_back,
				tax_ids: tax_ids
			}
		}).done(function(data) {

			$('#print_area').html(data);
			get_user_sale_summary();
			$('#cash_amount').val(0);
			$('#customer_name').val("");
			$('#customer_mobile_no').val("");
			$('#pay_able_total').html("0.00");
			$('#cash_back').html("0.00");
			$('#discount').val(0);
			$('#item_list').html('');
			$('#print_area').html(data);
			//Print2(data);
			window.print();
		});



	}



	function add_discount() {
		discount = parseFloat($('#discount').val());
		pay_able = parseFloat($('#pay_able').html());
		$('#payment_discount').html(discount);
		$('#pay_able_total').html(pay_able - discount);
		cash_calulator();

	}

	function cash_calulator() {
		cash_amount = parseFloat($('#cash_amount').val());
		pay_able_total = parseFloat($('#pay_able_total').html());
		$('#cash_back').html(cash_amount - pay_able_total);
	}

	$(function() {
		var availableTags = [
			<?php foreach ($sale_items as $sale_item) {
				echo '"' . $sale_item->name . '", ';
				if ($sale_item->name != "") {
					echo '"' . $sale_item->item_code_no . '", ';
				}
			} ?>
		];
		$("#tags").autocomplete({
			source: availableTags
		});
	});

	$('#tags').on('keydown', function(e) {
		if (e.keyCode == 13) {
			var search_item = $('#tags').val();
			$('#item_list').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url(ADMIN_DIR . "return_point/get_search_item") ?>",
				data: {
					search_item: search_item
				}
			}).done(function(data) {
				$('#item_list').html(data);
				get_user_sale_summary();
			});
		}

	});

	function update_user_item_quantity(user_item_id) {
		//item_quantity: item_quantity.replace(/[^a-zA-Z0-9]/g, ''),
		if (event.key === 'Enter') {
			var item_quantity = $('#user_item_' + user_item_id).val();
			$('#item_list').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url(ADMIN_DIR . "return_point/update_user_item_quantity") ?>",
				data: {
					user_item_id: user_item_id,
					item_quantity: item_quantity,
				}
			}).done(function(data) {
				$('#item_list').html(data);
				get_user_sale_summary();

			});
		}

	}

	function get_user_sale_summary() {

		//$('#item_sale_summary').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
		//return null;
		$.ajax({
			type: "POST",
			url: "<?php echo site_url(ADMIN_DIR . "return_point/user_items_return_summary") ?>",
			data: {}
		}).done(function(data) {
			//alert(data);
			$('#item_sale_summary').html(data);
		});


	}
</script>