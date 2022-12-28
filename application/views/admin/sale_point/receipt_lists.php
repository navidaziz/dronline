<table class="table ">
    <tr>
        <th>#</th>
        <th>Sale ID</th>
        <th>Date</th>
        <th></th>
        <th>Payment Type</th>
        <th>Customer Name</th>
        <!-- <th>Mobile Number</th> -->
        <th>Items Price (Rs)</th>
        <th>Tax</th>
        <th>Discount (Rs)</th>
        <th>Total Amount (Rs)</th>
        <th>Receipts</th>
    </tr>
    <?php
    $count = 1;
    foreach ($sales as $sale) { ?>
        <tr>
            <td><?php echo $count++ ?></td>
            <td><?php echo $sale->sale_id ?></td>
            <td>
                <small><?php echo date("dM,y", strtotime($sale->created_date)) ?></small>
            </td>
            <td>

                <?php if ($sale->return) { ?> <span style="color: red;">Return</span> <?php } else { ?> <span style="color: green;">Sale</span> <?php } ?>
            </td>
            <td><?php echo $sale->payment_type ?></td>
            <td><?php echo $sale->customer_name; ?></td>
            <!-- <td><?php echo $sale->customer_mobile_no; ?></td> -->
            <td><?php echo $sale->items_total_price; ?></td>
            <td><?php echo $sale->total_tax_pay_able; ?></td>
            <td><?php echo $sale->discount; ?></td>
            <td><?php echo $sale->total_payable; ?></td>
            <td><a href="javascript: return 0;" onclick="search_by_receipt_no('<?php echo $sale->sale_id ?>')">Receipt</a></td>
        </tr>
    <?php } ?>

</table>