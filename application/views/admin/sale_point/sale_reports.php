<div class="row">


    <div class="col-md-3">
        <div class="box border primary">
            <div class="box-title">
                <h4><i class="fa fa-money"></i>Today Sales Summary</h4>

            </div>
            <div class="box-body">
                <div class="sparkline-row">
                    <span class="title">Items Sales Amount</span>
                    <span class="value">Rs: <?php echo round($today_sale_summary->items_price, 2); ?></span>
                </div>
                <div class="sparkline-row">
                    <span class="title">Taxes</span>
                    <span class="value">Rs: <?php echo round($today_sale_summary->total_tax, 2); ?></span>
                    <span class="title">Discounts</span>
                    <span class="value">Rs: <?php echo round($today_sale_summary->discount, 2); ?></span>
                </div>
                <div class="sparkline-row">
                    <span class="title">Total Today Sale Amount</span>
                    <span class="value">Rs: <?php echo round($today_sale_summary->total_sale, 2); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 font-900">
        <h4>Reports</h4>
        <ol>
            <li class="text-primary"> <a class="text-primary" target="_new" href="<?php echo  site_url(ADMIN_DIR . "sale_point/today_items_sale_report"); ?>">
                    Print Today Sale Report</a></li>
            <li class="text-primary"> <a class="text-primary" target="_new" href="<?php echo  site_url(ADMIN_DIR . "sale_point/print_stock_report"); ?>">
                    Print Stock Report</a></li>
            <li>
                <form target="_blank" method="get" action="items_sale_report">
                    <table>
                        <tr>
                            <th colspan="3">
                                Items Wise Sale Report
                            </th>
                        </tr>
                        <tr>
                            <th> Start Date: </th>
                            <td> <input type="date" value="" name="start_date" /> </td>
                            <th> End Date </th>
                            <td><input required placeholder="dd-mm-yyyy" type="date" value="<?php echo date("d/m/Y") ?>" name="end_date" /></td>
                            <th colspan="2">
                                <input required placeholder="dd-mm-yyyy" type="submit" value="Sale Report" name="Sale Report" />
                            </th>
                        </tr>
                    </table>
                </form>
            </li>

            <li>
                <form target="_blank" method="get" action="day_wise_sale_report">
                    <table>
                        <tr>
                            <th colspan="3">
                                Day Wise Sale Report
                            </th>
                        </tr>
                        <tr>
                            <th> Start Date: </th>
                            <td> <input type="date" value="" name="start_date" /> </td>
                            <th> End Date </th>
                            <td><input required placeholder="dd-mm-yyyy" type="date" value="<?php echo date("d/m/Y") ?>" name="end_date" /></td>
                            <th colspan="2">
                                <input required placeholder="dd-mm-yyyy" type="submit" value="Sale Report" name="Sale Report" />
                            </th>
                        </tr>
                    </table>
                </form>
            </li>

        </ol>
    </div>

</div>