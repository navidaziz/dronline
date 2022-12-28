<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Invoice</title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>CCML</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/responsive.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css" media="screen,print" />


  <style>
    body {
      background: rgb(204, 204, 204);
    }

    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
      width: 21cm;
      /* height: 29.7cm;  */
      height: auto;
    }

    page[size="A4"][layout="landscape"] {
      width: 29.7cm;
      height: 21cm;
    }

    page[size="A3"] {
      width: 29.7cm;
      height: 42cm;
    }

    page[size="A3"][layout="landscape"] {
      width: 42cm;
      height: 29.7cm;
    }

    page[size="A5"] {
      width: 14.8cm;
      height: 21cm;
    }

    page[size="A5"][layout="landscape"] {
      width: 21cm;
      height: 14.8cm;
    }

    @media print {

      body,
      page {
        margin: 0;
        box-shadow: 0;
        color: black;
      }

    }


    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      padding: 8px;
      line-height: 1;
      vertical-align: top;
      border-top: 1px solid #ddd;
      font-size: 12px !important;
    }
  </style>
</head>

<body>
  <page size='A4'>
    <div style="padding: 5px;  padding-left:20px; padding-right:20px; " contenteditable="true">
      <h3 style="text-align: center;"> Tareen Infertility & Impotence Center Peshawar </h3>
      <h4 style="text-align: center;">Day's Wise Sale Report From <?php echo date('d M, Y', strtotime($startdate)) . " - " . date('d M, Y', strtotime($enddate)); ?></h4>



      <table class="table table-bordered" id="today_categories_wise_report">
        <thead>

          <tr>
            <th>#</th>
            <th>Date</th>
            <!-- <th>Item Name</th>
            <th>Cost Price</th>
            <th>Unit Price</th>
            <th>Discount</th>
            <th>Sale Price</th>
            <th>Qyt</th> -->
            <th>Net Total</th>
            <!-- <th>Profit</th> -->
          </tr>

        </thead>
        <tbody>

          <?php
          $count = 1;
          foreach ($today_items_sales as $report) { ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo date('d M, Y', strtotime($report->created_date)); ?></td>
              <!-- <td><?php echo $report->item_name; ?></td>
              <td><?php echo $report->cost_price; ?></td>
              <td><?php echo $report->unit_price; ?></td>
              <td><?php echo $report->item_discount; ?></td>
              <td><?php echo $report->sale_price; ?></td>
              <td><?php echo $report->qty; ?></td> -->
              <td><?php echo round($report->net_total, 2); ?></td>
              <!-- <td><?php echo round($report->net_total - ($report->cost_price * $report->qty), 2); ?></td> -->
            </tr>
          <?php } ?>


          <tr>
            <?php
            $query = "SELECT  
                      SUM(si.total_price) as net_total,
                      SUM(si.cost_price*si.sale_items) as cost_items_total 
                      FROM `sales_items` as si 
                      WHERE DATE(`created_date`) BETWEEN " . $start_date . " and " . $end_date . "";
            $today_items_sale = $this->db->query($query);

            ?>
            <td colspan="2">Total</td>
            <td><?php

                if ($today_items_sale) {
                  echo round($today_items_sale->result()[0]->net_total, 2) . " Rs";
                }
                ?></td>

            <!-- <td><?php

                      if ($today_items_sale) {
                        echo round($today_items_sale->result()[0]->net_total - $today_items_sale->result()[0]->cost_items_total, 2) . " Rs";
                      }
                      ?></td> -->
          </tr>
          <!--<tr>

            <td colspan="3" style="text-align: right;">
              <small>
                Total Items Sale Amount: <?php echo round($today_sale_summary->items_price, 2); ?><br /> 
            Total Taxes: <?php echo $today_sale_summary->total_tax; ?><br />
            Total Discounts: <?php echo $today_sale_summary->discount; ?></br />
            Total Sale: <?php echo round($today_sale_summary->total_sale, 2); ?>
            </small>
            </td> 

          </tr>-->

        </tbody>
      </table>






      <br />

      <br />
      <?php

      $query = "SELECT
                  `roles`.`role_title`,
                  `users`.`user_title`  
              FROM `roles`,
              `users` 
              WHERE `roles`.`role_id` = `users`.`role_id`
              AND `users`.`user_id`='" . $this->session->userdata('user_id') . "'";
      $user_data = $this->db->query($query)->result()[0];
      ?> </p>

      <p class="divFooter" style="text-align: right;"><b><?php echo $user_data->user_title; ?> <?php echo $user_data->role_title; ?></b>
        <br />Tareen Infertility & Impotence Center Peshawar <br />
        <strong>Printed at: <?php echo date("d, F, Y h:i:s A", time()); ?></strong>
      </p>


    </div>

  </page>
</body>



</html>