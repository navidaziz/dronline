<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Stock Detail</title>
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
      <h4 style="text-align: center;">Pharmacy Current Stock Report ( Date: <?php echo date("d F, Y ", time()) ?>)</h4>


      <table class="table table-bordered" style="font-size: 12px;">
        <thead>
          <tr>
            <th>#</th>
            <th><?php echo $this->lang->line('name'); ?></th>

            <th><?php echo $this->lang->line('cost_price'); ?></th>
            <!-- <th>Total</th> -->
            <th><?php echo $this->lang->line('unit_price'); ?></th>
            <th>Profit %</th>
            <!-- <th>Total</th> -->
            <th>Dis.</th>
            <th>Sale Price</th>

            <th>Expire After</th>
            <!-- <th><?php echo $this->lang->line('reorder_level'); ?></th> -->
            <th>In Stock</th>
            <th>location</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 1;
          $total_items_price_stock = 0;
          $total_items_price_sale = 0;
          foreach ($items as $item) : ?>

            <tr <?php if (@round((($item->unit_price - $item->cost_price) * 100 / $item->cost_price), 1) < 12) { ?> style="background-color: #F 7D5CA;" <?php } ?> <?php if (@round((($item->unit_price - $item->cost_price) * 100 / $item->cost_price), 1) > 15) { ?> style="background-color: #9 0EE90;" <?php } ?>>
              <td><?php echo $count++; ?></td>
              <td> <?php echo $item->name; ?> </td>

              <td> <?php echo $item->cost_price; ?></td>
              <!-- <td> --><?php $total_items_price_stock += $item->cost_price * $item->total_quantity;
                            // echo $item->cost_price * $item->total_quantity;
                            ?>
              <!-- </td> -->
              <td> <?php echo $item->unit_price; ?>
              </td>
              <td> <?php echo @round((($item->unit_price - $item->cost_price) * 100 / $item->cost_price), 1) . " %"; ?> </td>
              <!-- <td>--> <?php $total_items_price_sale += $item->unit_price * $item->total_quantity;
                            //echo $item->unit_price * $item->total_quantity;
                            ?>
              <!-- </td> -->
              <td> <?php echo $item->discount; ?> </td>
              <td> <?php echo $item->sale_price; ?> </td>

              <td title="<?php echo $item->expiry_date; ?>"> <?php
                                                              if ($item->total_quantity > 0) {
                                                                $current_date = new DateTime('today');  //current date or any date
                                                                $expiry_date = new DateTime($item->expiry_date);   //Future date
                                                                $diff = $expiry_date->diff($current_date)->format("%a");  //find difference
                                                                $days = intval($diff);   //rounding days
                                                                echo $days . "";
                                                                // 
                                                              } ?> </td>
              <!-- <td> <?php echo $item->reorder_level; ?> </td> -->
              <td><?php echo $item->total_quantity ?></td>
              <td> <?php echo $item->location; ?> </td>

            </tr>
          <?php endforeach; ?>
          <tr>
            <th colspan="8" style="text-align: right;">Total Current Stock Amount</th>
            <th colspan="2"><?php echo $total_items_price_stock; ?> Rs.</th>
            <!-- <th colspan="2"></th>
            <th><?php echo $total_items_price_sale - $total_items_price_stock; ?></th> -->

          </tr>
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