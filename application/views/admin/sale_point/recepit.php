<style>
    .table1-bordered1 {
        border: 1px solid black !important;
    }

    .table1>thead>tr>th,
    .table1>tbody>tr>th,
    .table1>tfoot>tr>th,
    .table1>thead>tr>td,
    .table1>tbody>tr>td,
    .table1>tfoot>tr>td {
        padding: 3px;
        line-height: 1.628571;
        vertical-align: top;
        border-top: 1px solid #ddd;
        color: black !important;
        border: 1px solid black;
    }

    }


    .table1>thead>tr>th,
    .table1>tbody>tr>th,
    .table1>tfoot>tr>th,
    .table1>thead>tr>td,
    .table1>tbody>tr>td,
    .table1>tfoot>tr>td {
        padding: 3px;
        line-height: 1.628571;
        vertical-align: top;
        border-top: 1px solid #ddd;
        color: black !important;
        border: 1px solid black;
    }
</style>

</style>

<table class="table1 table1-bordered1" style="width: 100% !important;">
    <thead>
        <tr>
            <th colspan="5">
                <h4 style="text-align: center;">Tareen Infertility & Impotence Center Peshawar</h4>
                <h6 style="text-align: center; font-size: 11px;">Liberty Mall Opp: Air Port Runway, University Rd, Tahkal, Peshawar, Khyber Pakhtunkhwa 25000
                    <br /> PHONE 0000-000000
                </h6>
                <div id="sale_id">
                    <?php if ($sale->return) { ?> <span style="color: black;">Return</span> <?php } else { ?> <span style="color: black;">Sale</span> <?php } ?> -


                    Receipt No: <strong><?php echo $sale->sale_id; ?></strong></div>
                <div id="employee">Customer: <?php echo $sale->customer_name; ?> <?php echo "- " . $sale->customer_mobile_no; ?></strong> </div>


            </th>
        </tr>
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
        <tr>
            <td colspan="5">
                <small>
                    <p style="text-align: center;"> Date: <?php echo date('d M, y - h:i A', strtotime($sale->created_date)); ?> -----
                        Employee: <?php echo $sale->user_title; ?>
                    </p>
                </small>
            </td>
        </tr>

    </tbody>
</table>