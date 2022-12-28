<style>
    .table1>thead>tr>th,
    .table1>tbody>tr>th,
    .table1>tfoot>tr>th,
    .table1>thead>tr>td,
    .table1>tbody>tr>td,
    .table1>tfoot>tr>td {
        padding: 3px;
        vertical-align: top;
        border-top: 1px solid #ddd;
        font-size: 12px !important;
        font-family: Calibri, sans-serif !important;
    }
</style>

<div id="receipt_header">

</div>
<div id="receipt_general_info">

</div>
<table class="table table1 table-bordered">
    <tr>
        <th colspan="2" style="font-size: 17px !important; text-align:center"> ATareen Infertility & Impotence Center Peshawar
        </th>
    </tr>
    <tr>
        <td>
            <div id="sale_id">Receipt No: <strong><?php echo $sale->sale_id; ?></strong></div>
            <div id="employee">Customer: <?php echo $sale->customer_name; ?> <?php echo "- " . $sale->customer_mobile_no; ?></strong> </div>
        </td>
        <td>
            <div id="sale_id">Date: <?php echo date('d M, y - h:i A', strtotime($sale->created_date)); ?></div>
            <div id="employee">Employee: <?php echo $sale->user_title; ?></div>
        </td>
    </tr>
</table>
<table class="table table1 table-bordered">
    <thead>
        <tr>
            <th style="width:200px">Item</th>
            <th>Price</th>
            <th>Dis</th>
            <th>Qty.</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($sale_items as $item) { ?>
            <tr>
                <td><?php echo $item->item_name;  ?></td>
                <td><?php echo $item->unit_price;  ?></td>
                <td><?php echo $item->item_discount;  ?></td>
                <td><?php echo $item->quantity;  ?></td>
                <td><?php echo $item->total_price;  ?></td>
            </tr>
        <?php } ?>


        <tr>
            <td colspan="5" align="right">
                <span style="font-size:15px">
                    <?php if ($sale_taxes) { ?>
                        Total: Rs <?php echo $sale->items_total_price; ?><br />
                        <?php foreach ($sale_taxes as  $sale_taxe) {
                            echo $sale_taxe->tax_name . " - " . $sale_taxe->tax_percentage . " % <br />";
                        } ?>

                        Taxes <?php echo $sale->items_total_price_including_tax - $sale->items_total_price; ?> %<br />
                    <?php } ?>
                    Total <?php echo $sale->items_total_price_including_tax; ?><br />
                    Discount: Rs <?php echo $sale->discount; ?><br />
                    Paid: Rs <?php echo $sale->total_payable; ?><br />
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="5" align="center">
                <p style="font-size: 9px !important;">Return Policy </p>
            </td>
        </tr>

    </tbody>
</table>