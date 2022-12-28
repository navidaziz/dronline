<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-3">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php echo $title; ?></h4>
            </div>
            <div class="box-body">

                <div class="table-responsive">

                    <table class="table">
                        <thead>

                        </thead>
                        <tbody>
                            <?php foreach ($items as $item) : ?>


                                <tr>
                                    <th><?php echo $this->lang->line('name'); ?></th>
                                    <td>
                                        <?php echo $item->name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('category'); ?></th>
                                    <td>
                                        <?php echo $item->category; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('item_code_no'); ?></th>
                                    <td>
                                        <?php echo $item->item_code_no; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('description'); ?></th>
                                    <td>
                                        <?php echo $item->description; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('cost_price'); ?></th>
                                    <td>
                                        <?php echo $item->cost_price; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('unit_price'); ?></th>
                                    <td>
                                        <?php echo $item->unit_price; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <h4>In Stock </h4>
                                    </th>
                                    <td>
                                        <h4><?php echo $item->total_quantity; ?></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('reorder_level'); ?></th>
                                    <td>
                                        <?php echo $item->reorder_level; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('location'); ?></th>
                                    <td>
                                        <?php echo $item->location; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><?php echo $this->lang->line('Status'); ?></th>
                                    <td>
                                        <?php echo status($item->status); ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>




                </div>


            </div>

        </div>
    </div>

    <div class="col-md-9">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-clipboard" aria-hidden="true"></i> Inventory Detail</h4>
            </div>
            <div class="box-body">
                <style>
                    .table2>thead>tr>th,
                    .table2>tbody>tr>th,
                    .table2>tfoot>tr>th,
                    .table2>thead>tr>td,
                    .table2>tbody>tr>td,
                    .table2>tfoot>tr>td {
                        padding: 5px;
                        line-height: 1.5;
                        vertical-align: top;
                    }
                </style>
                <script>
                    function stock_in() {
                        $('#stock_in').show();
                        $('#stock_return').hide();
                    }

                    function stock_return() {
                        $('#stock_in').hide();
                        $('#stock_return').show();
                    }
                </script>

                <div class="table-responsive">
                    <form method="post" action="<?php echo  site_url(ADMIN_DIR . "items/add_item_stocks") ?>">
                        <input type="hidden" name="item_id" id="item_id" value="<?php echo $items[0]->item_id; ?>" />
                        Stock In: <input type="radio" value="stock_in" name="traction_type" onclick="stock_in()" /> Stock Return: <input type="radio" value="stock_return" onclick="stock_return()" name="traction_type" />
                        <table class="table table-bordered table2" style="line-height: 0.5px; display:block" id="stock_in">

                            <tr>

                                <td>
                                    <strong>Cost Price</strong>
                                    <input step="any" type="number" name="cost_price" value="<?php if ($item->cost_price) {
                                                                                                    echo $item->cost_price;
                                                                                                } else {
                                                                                                    echo 0;
                                                                                                } ?>" id="cost_price" class="form-control" required="required" title="Cost Price" placeholder="Cost Price">
                                </td>
                                <td>
                                    <strong>Unit Price</strong>
                                    <input step="any" type="number" name="unit_price" value="<?php if ($item->unit_price) {
                                                                                                    echo $item->unit_price;
                                                                                                } else {
                                                                                                    echo 0;
                                                                                                } ?>" id="unit_price" class="form-control" title="Unit Price" placeholder="Unit Price">
                                </td>
                                <td>
                                    <strong>Total New Stock</strong>
                                    <input required="required" type="number" name="transaction" value="" id="transaction" class="form-control" title="Unit" placeholder="Transaction">
                                </td>
                                <td>
                                    <strong>Expiry Date</strong>
                                    <input required="required" type="date" name="date" value="" id="date" class="form-control" title="date" placeholder="date" />
                                </td>

                                <td>
                                    <strong>Action</strong>
                                    <input class="btn btn-primary btn-sm" type="submit" name="add_stock" value="Add Stock" />
                                </td>
                            </tr>
                        </table>
                    </form>
                    <form method="post" action="<?php echo  site_url(ADMIN_DIR . "items/return_item_stocks") ?>">
                        <input type="hidden" name="item_id" id="item_id" value="<?php echo $items[0]->item_id; ?>" />
                        <table class="table table-bordered table2" style="line-height: 0.5px; display:none" id="stock_return">

                            <tr>
                                <td>
                                    <strong>Cost Price</strong>
                                    <input step="any" type="number" name="cost_price" value="<?php if ($item->cost_price) {
                                                                                                    echo $item->cost_price;
                                                                                                } else {
                                                                                                    echo 0;
                                                                                                } ?>" id="cost_price" class="form-control" required="required" title="Cost Price" placeholder="Cost Price">
                                </td>
                                <td>
                                    <strong>Unit Price</strong>
                                    <input step="any" type="number" name="unit_price" value="<?php if ($item->unit_price) {
                                                                                                    echo $item->unit_price;
                                                                                                } else {
                                                                                                    echo 0;
                                                                                                } ?>" id="unit_price" class="form-control" title="Unit Price" placeholder="Unit Price">
                                </td>

                                <td>
                                    <strong>Total Stock Return</strong>
                                    <input required="required" type="number" name="transaction" value="" id="transaction" class="form-control" title="Unit" placeholder="Transaction">
                                </td>
                                <td>
                                    <strong>Date</strong>
                                    <input required="required" type="date" name="date" value="" id="date" class="form-control" title="date" placeholder="date" />
                                </td>

                                <td>
                                    <strong>Remarks</strong>
                                    <input type="text" name="remarks" value="" id="remarks" class="form-control" title="remarks" placeholder="remarks" />
                                </td>

                                <td>
                                    <strong>Action</strong>
                                    <input class="btn btn-danger btn-sm" type="submit" name="return_stock" value="Return Stock" />
                                </td>
                            </tr>
                        </table>
                    </form>


                    <table class="table table-bordered table2">
                        <thead>
                            <th>#</th>
                            <th>Supplier Name</th>
                            <th>Batch Number</th>
                            <th>Expiry Date</th>
                            <th>Quantity</th>
                            <th>Trade Price</th>
                            <!-- <th>Net Amount</th> -->
                            <!-- <th>Unit Price</th> -->
                            <th>Transaction Type</th>
                            <th>Remarks</th>
                            <th>Created By</th>
                            <!-- <th>Action</th> -->
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($inventories as $inventory) : ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo @$suppliers[$inventory->supplier_id]; ?></td>
                                    <td><?php echo $inventory->batch_number; ?></td>
                                    <td>
                                        <?php if ($inventory->expiry_date) { ?>
                                            <?php echo date('d M, Y', strtotime($inventory->expiry_date)); ?>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $inventory->inventory_transaction; ?></td>
                                    <td><?php echo $inventory->item_cost_price; ?></td>
                                    <!-- <td><?php echo $inventory->item_cost_price * $inventory->inventory_transaction; ?></td> -->
                                    <!-- <td><?php echo $inventory->item_unit_price; ?></td> -->
                                    <td><strong><?php echo $inventory->transaction_type; ?></strong>
                                        <?php if ($inventory->return_date) { ?>
                                            <small><?php echo date('d M, Y', strtotime($inventory->return_date)); ?></small>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $inventory->remarks; ?></td>
                                    <td><?php echo $inventory->user_title; ?></td>
                                    <!-- <td><a href="<?php echo site_url(ADMIN_DIR . "suppliers/remove_supplier_item/" . $inventory->supplier_id . "/" . $inventory->supplier_invoice_id . "/" . $inventory->inventory_id) ?>">Remove</a></td>
                                </tr> -->

                                <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>


            </div>

        </div>
    </div>

</div>