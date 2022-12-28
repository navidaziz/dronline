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
      width: 98%;
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


    .table1>thead>tr>th,
    .table1>tbody>tr>th,
    .table1>tfoot>tr>th,
    .table1>thead>tr>td,
    .table1>tbody>tr>td,
    .table1>tfoot>tr>td {
      border: 1px solid black;
      text-align: center;
    }
  </style>
</head>

<body>
  <page size='A4'>
    <div style="padding: 5px;  padding-left:20px; padding-right:20px; " contenteditable="true">
      <h3 style="text-align: center;"> Tareen Infertility & Impotence Center Peshawar </h3>
      <h4 style="text-align: center;">Month <?php echo $month ?> Progress Report</h4>
      <div style="overflow-x:auto;">
        <table class="table1" style="font-size: 9px !important; width:99%; border-collapse: collapse !important; ">

          <tr>
            <th></th>
            <th colspan="5">LAB</th>
            <th colspan="5">ECG</th>
            <th colspan="5">X-RAY</th>
            <th colspan="5">ULTRASOUND</th>
            <th colspan="5">Dr. Naila</th>
            <th colspan="5">Dr. Shabana</th>
            <th colspan="5">US-Doppler (Dr.Shabana)</th>
            <th colspan="2">Pharmacy</th>
            <th colspan="4">Total</th>
          </tr>
          <tr>
            <th>Date</th>
            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Total</td>
            <td>Canc</td>
            <td>Conf</td>
            <td>Dis</td>
            <td>Total</td>

            <td>Sale</td>
            <td>Profit</td>


            <th>Discount</th>
            <th>Total</th>
            <th>Expense</th>
            <th>Income</th>

          </tr>
          <?php
          $count = 0;
          $total_income = 0;

          foreach ($day_wise_monthly_report as $date => $report) {
            $total_income += @$report->total; ?>
            <tr <?php if ($count == 0) { ?> style="backgro und-color:#9F9 !important; " <?php $count++;
                                                                                      } ?>>
              <td><?php echo $date; ?></td>
              <td><?php echo @$report->lab_cancelled + @$report->lab_count ?></td>
              <td><?php echo @$report->lab_cancelled ?></td>
              <td><?php echo @$report->lab_count ?></td>
              <td><?php echo @$report->lab_discount_count ?>-<?php echo @$report->lab_discount ?></td>
              <td><?php echo @$report->lab ?></td>


              <td><?php echo @$report->ecg_cancelled + @$report->ecg_count ?></td>
              <td><?php echo @$report->ecg_cancelled ?></td>
              <td><?php echo @$report->ecg_count ?></td>
              <td><?php echo @$report->ecg_discount_count ?> - <?php echo @$report->ecg_discount ?></td>
              <td><?php echo @$report->ecg ?></td>

              <td><?php echo @$report->x_ray_cancelled + @$report->x_ray_count ?></td>
              <td><?php echo @$report->x_ray_cancelled ?></td>
              <td><?php echo @$report->x_ray_count ?></td>
              <td><?php echo @$report->x_ray_discount_count ?> - <?php echo @$report->x_ray_discount ?></td>
              <td><?php echo @$report->x_ray ?></td>


              <td><?php echo @$report->ultrasound_cancelled + @$report->ultrasound_count ?></td>
              <td><?php echo @$report->ultrasound_cancelled ?></td>
              <td><?php echo @$report->ultrasound_count ?></td>
              <td><?php echo @$report->ultrasound_discount_count ?> - <?php echo @$report->ultrasound_discount ?></td>
              <td><?php echo @$report->ultrasound ?></td>



              <td><?php echo @$report->dr_naila_cancelled + @$report->dr_naila_count ?></td>
              <td><?php echo @$report->dr_naila_cancelled ?></td>
              <td><?php echo @$report->dr_naila_count ?></td>
              <td><?php echo @$report->dr_naila_discount_count ?> - <?php echo @$report->dr_naila_discount ?></td>
              <td><?php echo @$report->dr_naila ?></td>



              <td><?php echo @$report->dr_shabana_cancelled + @$report->dr_shabana_count ?></td>
              <td><?php echo @$report->dr_shabana_cancelled ?></td>
              <td><?php echo @$report->dr_shabana_count ?></td>
              <td><?php echo @$report->dr_shabana_discount_count ?> - <?php echo @$report->dr_shabana_discount ?></td>
              <td><?php echo @$report->dr_shabana ?></td>



              <td><?php echo @$report->dr_shabana_us_doppler_cancelled + @$report->dr_shabana_us_doppler_count ?></td>
              <td><?php echo @$report->dr_shabana_us_doppler_cancelled ?></td>
              <td><?php echo @$report->dr_shabana_us_doppler_count ?></td>
              <td><?php echo @$report->dr_shabana_us_doppler_discount_count ?> - <?php echo @$report->dr_shabana_us_doppler_discount ?></td>
              <td><?php echo @$report->dr_shabana_us_doppler ?></td>
              <?php $query = "SELECT ROUND(SUM(si.total_price)) AS total_sale,
                      (ROUND(SUM(si.sale_items*si.unit_price))-ROUND(SUM(si.sale_items*si.cost_price))) AS total_profit
                      FROM `sales_items` AS si
                      WHERE DATE(`created_date`) = '" . date('Y-m-d', strtotime($date)) . "'";
              $today_sale_summary = $this->db->query($query);
              if ($today_sale_summary) {
                $today_sale_summary = $today_sale_summary->result()[0];
              }
              ?>
              <td><?php echo $today_sale_summary->total_sale; ?></td>
              <td><?php echo $today_sale_summary->total_profit; ?></td>

              <td><?php echo @$report->discount_count; ?> - <?php echo @$report->discount; ?></td>
              <td><?php echo @$report->total; ?></td>
              <td><?php echo @$report->expense; ?></td>
              <td><?php echo @($report->total - $report->expense); ?></td>



            </tr>
          <?php } ?>



          <?php


          foreach ($monthly_total_report as $date => $report) { ?>
            <tr>
              <th>Total</th>
              <th><?php echo @$report->lab_cancelled + @$report->lab_count ?></th>
              <th><?php echo @$report->lab_cancelled ?></th>
              <th><?php echo @$report->lab_count ?></th>
              <th><?php echo @$report->lab_discount_count ?>-<?php echo @$report->lab_discount ?></th>
              <th><?php echo @$report->lab ?></th>


              <th><?php echo @$report->ecg_cancelled + @$report->ecg_count ?></th>
              <th><?php echo @$report->ecg_cancelled ?></th>
              <th><?php echo @$report->ecg_count ?></th>
              <th><?php echo @$report->ecg_discount_count ?> - <?php echo @$report->ecg_discount ?></th>
              <th><?php echo @$report->ecg ?></th>

              <th><?php @$report->x_ray_cancelled + @$report->x_ray_count ?></th>
              <th><?php echo @$report->x_ray_cancelled ?></th>
              <th><?php echo @$report->x_ray_count ?></th>
              <th><?php echo @$report->x_ray_discount_count ?> - <?php echo @$report->x_ray_discount ?></th>
              <th><?php echo @$report->x_ray ?></th>


              <th><?php echo @$report->ultrasound_cancelled + @$report->ultrasound_count ?></th>
              <th><?php echo @$report->ultrasound_cancelled ?></th>
              <th><?php echo @$report->ultrasound_count ?></th>
              <th><?php echo @$report->ultrasound_discount_count ?> - <?php echo @$report->ultrasound_discount ?></th>
              <th><?php echo @$report->ultrasound ?></th>



              <th><?php echo @$report->dr_naila_cancelled + @$report->dr_naila_count ?></th>
              <th><?php echo @$report->dr_naila_cancelled ?></th>
              <th><?php echo @$report->dr_naila_count ?></th>
              <th><?php echo @$report->dr_naila_discount_count ?> - <?php echo @$report->dr_naila_discount ?></th>
              <th><?php echo @$report->dr_naila ?></th>



              <th><?php echo @$report->dr_shabana_cancelled + @$report->dr_shabana_count ?></th>
              <th><?php echo @$report->dr_shabana_cancelled ?></th>
              <th><?php echo @$report->dr_shabana_count ?></th>
              <th><?php echo @$report->dr_shabana_discount_count ?> - <?php echo @$report->dr_shabana_discount ?></th>
              <th><?php echo @$report->dr_shabana ?></th>



              <th><?php echo @$report->dr_shabana_us_doppler_cancelled + @$report->dr_shabana_us_doppler_count ?></th>
              <th><?php echo @$report->dr_shabana_us_doppler_cancelled ?></th>
              <th><?php echo @$report->dr_shabana_us_doppler_count ?></th>
              <th><?php echo @$report->dr_shabana_us_doppler_discount_count ?> - <?php echo @$report->dr_shabana_us_doppler_discount ?></th>
              <th><?php echo @$report->dr_shabana_us_doppler ?></th>


              <?php $query = "SELECT ROUND(SUM(si.total_price)) AS total_sale,
                      (ROUND(SUM(si.sale_items*si.unit_price))-ROUND(SUM(si.sale_items*si.cost_price))) AS total_profit
                      FROM `sales_items` AS si
                      WHERE MONTH(`created_date`) = '" . $month_filter . "'
                      AND YEAR(`created_date`) = '" . $year_filter . "'
                      ";
              $today_sale_summary = $this->db->query($query);
              if ($today_sale_summary) {
                $today_sale_summary = $today_sale_summary->result()[0];
              }
              ?>
              <td><?php echo $today_sale_summary->total_sale; ?></td>
              <td><?php echo $today_sale_summary->total_profit; ?></td>

              <th><?php echo @$report->discount_count; ?> - <?php echo @$report->discount; ?></th>
              <th><?php echo @$report->total; ?></th>
              <th><?php echo @$report->expense; ?></th>
              <th><?php echo @($report->total - $report->expense); ?></th>



            </tr>
          <?php } ?>
          <tr>
            <td colspan="42">
              Total Pharmacy Sale: <?php echo $today_sale_summary->total_sale; ?> Rs. <br />
              Total Pharmacy Profit: <?php echo $today_sale_summary->total_profit; ?> Rs. <br />
              Other Income Total: <?php echo $report->total; ?> Rs.<br />
              Total Expenses: <?php echo @$report->expense; ?> Rs. <br />
              <strong>Grand Total: <?php echo (($report->total + $today_sale_summary->total_profit) - $report->expense); ?> Rs.</strong>




            </td>

          </tr>
        </table>
      </div>
      </br />
      <table class="table1" style="width: 99%;">
        <tr>
          <?php foreach ($categories_wise_cancellations as $category_name => $cancellation_reasons) { ?>
            <th><?php echo $category_name; ?></th>
          <?php } ?>
        </tr>
        <tr>
          <?php foreach ($categories_wise_cancellations as $category_name => $cancellation_reasons) { ?>
            <td style="text-align: left;">
              <?php foreach ($cancellation_reasons as $reason => $reason_total) { ?>
                <?php echo $reason . " - " . $reason_total . '<br />'; ?>
              <?php } ?>
            </td>
          <?php } ?>
        </tr>
      </table>
      <br />
      <table class="ta ble1" style="width: 99%;">
        <tr>
          <td>
            <table class="table1" style="width: 99% !important; ">
              <tr>
                <th colspan="7">
                  <h4 style="text-align: center;">Month <?php echo $month ?> Dr. OPDs Report</h4>
                </th>
              </tr>
              <tr>
                <th>#</th>
                <th>Doctor Name</th>
                <th>Total Appointments</th>
                <th>Cancelled</th>
                <th>Confirmed</th>
                <th>Discount</th>
                <th>Total RS</th>
              </tr>
              <?php
              $count = 1;
              foreach ($this_month_OPD_reports as $report) { ?>
                <tr>
                  <td><?php echo $count++; ?></td>
                  <td style="text-align: left;"><?php echo $report->test_group_name; ?></td>
                  <td><?php echo $report->total_count + $report->total_receipt_cancelled; ?></td>
                  <td><?php echo $report->total_receipt_cancelled; ?></td>
                  <td><?php echo $report->total_count; ?></td>
                  <td><?php echo $report->total_dis_count; ?> - <?php echo $report->total_discount; ?></td>

                  <td><?php echo $report->total_sum; ?></td>
                </tr>
              <?php } ?>
              <tr>
                <th colspan="2" style="text-align: right;">OPD Total</th>
                <th style="text-align: center;"><?php echo $this_month_total_OPD_reports[0]->total_count + $this_month_total_OPD_reports[0]->total_receipt_cancelled ?></th>
                <th style="text-align: center;"><?php echo $this_month_total_OPD_reports[0]->total_receipt_cancelled; ?></th>
                <th style="text-align: center;"><?php echo $this_month_total_OPD_reports[0]->total_count ?></th>
                <td><?php echo $this_month_total_OPD_reports[0]->total_dis_count; ?> - <?php echo $this_month_total_OPD_reports[0]->total_discount; ?></td>

                <th style="text-align: center;"><?php echo $this_month_total_OPD_reports[0]->total_sum ?></th>
              </tr>
            </table>
          </td>
          <td>
            <table class="table1" style="width: 99% !important; ">
              <tr>
                <th colspan="7">
                  <h4 style="text-align: center;">Month <?php echo $month ?> Dr. Referred After OPD Report</h4>
                </th>
              </tr>
              <tr>
                <th>#</th>
                <th>Doctor Name</th>
                <th>OPDs</th>
                <th>LAB</th>
                <th>ECG</th>
                <th>Ultrasound</th>
                <th>X-RAY</th>
              </tr>
              <?php
              $count = 1;
              foreach ($dr_refers as $report) { ?>
                <tr>
                  <td><?php echo $count++; ?></td>
                  <td style="text-align: left;"><?php echo $report->dr_name; ?></td>
                  <td><?php echo $report->opd; ?></td>
                  <td><?php echo $report->lab; ?></td>
                  <td><?php echo $report->ecg; ?></td>
                  <td><?php echo $report->ultrasound; ?></td>

                  <td><?php echo $report->x_ray; ?></td>
                </tr>
              <?php } ?>

            </table>
          </td>
        </tr>
      </table>
      <br />

      <table style="width: 100%;">
        <tr>
          <td style="width: 50%;">

            <?php
            foreach ($this_month_tests as $test_category) { ?>

              <table class="table1" style="width: 100%;">
                <tr>
                  <th colspan="4">
                    <h4 style="text-align: center;">Month <?php echo $month ?> <?php echo $test_category->test_category; ?> Report</h4>

                  </th>
                </tr>
                <tr>
                  <th>#</th>
                  <th>Test Name</th>
                  <th>Test Total</th>
                  <th>Total Rs</th>
                </tr>
                <?php $count = 1;
                foreach ($test_category->test_total as $this_month_test) { ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td style="text-align: left;"><?php echo $this_month_test->test_name  ?></td>
                    <td><?php echo $this_month_test->test_total ?></td>
                    <td><?php echo $this_month_test->total_rs ?></td>
                  </tr>
                <?php } ?>

              </table>
              <br />
            <?php } ?>
          </td>
          <td style="width: 50%; vertical-align: top;">
            <table class="table1" style="width: 100%;">
              <th colspan="7">
                <h4 style="text-align: center;">Month <?php echo $month ?> Expenses Report</h4>
              </th>
              <tr>
                <td>#</td>
                <td>Expense Type - Total</td>
                <td>Expense Type Total</td>
                <td>Expense Detail</td>
              </tr>
              <?php
              $total_expense = 0;
              $count = 1;
              foreach ($this_month_expenses as $expense_type) {
                $total_expense += $expense_type->expense_total;
              ?>
                <tr>
                  <td><?php echo $count++; ?></td>
                  <td><?php echo ucwords(strtolower($expense_type->expense_type)); ?></td>

                  <td>
                    <?php echo $expense_type->expense_total ?>
                  </td>
                  <td>
                    <table class="table1" style="width: 100%; font-size: 10px;">
                      <?php foreach ($expense_type->expense_detail as $expense) { ?>
                        <tr>
                          <td><?php echo date("d m,Y", strtotime($expense->created_date)); ?></td>
                          <td><?php echo $expense->expense_title; ?></td>
                          <td><?php echo $expense->expense_description; ?></td>
                          <td><?php echo $expense->expense_amount; ?></td>
                        </tr>
                      <?php } ?>
                    </table>

                  </td>
                </tr>
              <?php } ?>
              <tr>
                <th colspan="2">Total</th>
                <th colspan="3"><?php echo $total_expense ?></th>
              </tr>
            </table>
          </td>
        </tr>
      </table>









    </div>

    <br />


    <div style="padding: 5px;  padding-right:20px; " contenteditable="true">






    </div>



    <br />
    <div style="padding: 5px;  padding-right:20px; " contenteditable="true">


      <table class="table1" style="width: 100%; display: inline;">
        <th colspan="7">
          <h4 style="text-align: center;">Month <?php echo $month ?> Expenses Report</h4>
        </th>
        <tr>
          <td>Date</td>
          <td></td>
          <td>Total Expense</td>
        </tr>
        <?php foreach ($monthly_expenses as $date => $reports) { ?>
          <tr>
            <td><?php echo $date; ?></td>
            <td><?php
                if ($reports) { ?>
                <table class="table1" style="width: 100%;">
                  <tr>
                    <th>Expense</th>
                    <th>Expense Total</th>
                  </tr> <?php foreach ($reports as $report) { ?>
                    <tr>
                      <td><?php echo $report->expense_title; ?></td>
                      <td><?php echo $report->expense_total; ?></td>
                    </tr>
                  <?php } ?>
                </table>
              <?php } ?>
            </td>
            <td>100</td>
          </tr>
        <?php } ?>


      </table>





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