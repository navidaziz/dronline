<div class="container" style="margin-top:5px !important; font-size:11px;">
  <div class="row">
    <div class="row">


      <div class="col-md-6">
        <div class="box border blue" id="messenger">
          <div class="box-title">
            <h4><i class="fa fa-bar-chart"></i>Today Summary Report</h4>
          </div>
          <div class="box-body">
            <?php
            $total = 0;
            $cancelled = 0;
            $confirmed = 0;
            $discount_count = 0;
            $discount = 0;
            $total_rs = 0;
            ?>
            <h6>
              <table class="table table-bordered" id="today_categories_wise_report">
                <thead>

                  <tr>
                    <th>#</th>
                    <th>Catagories</th>
                    <th>Total</th>
                    <th>Cancelled</th>
                    <th>Confirmed</th>
                    <th>Discounts</th>
                    <th>Total Rs</th>
                  </tr>

                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <th>LAB</th>
                    <td><?php
                        $total += @$today_report->lab_cancelled + $today_report->lab_count;
                        echo @$today_report->lab_cancelled + $today_report->lab_count ?></td>
                    <td><?php
                        $cancelled += @$today_report->lab_cancelled;
                        echo @$today_report->lab_cancelled ?></td>
                    <td><?php
                        $confirmed += @$today_report->lab_count;
                        echo @$today_report->lab_count ?></td>
                    <td><?php
                        $discount_count += @$today_report->lab_discount_count;
                        $discount += @$today_report->lab_discount;
                        echo @$today_report->lab_discount_count ?>
                      -<?php echo @$today_report->lab_discount ?></td>
                    <td><?php
                        $total_rs += @$today_report->lab;
                        echo @$today_report->lab ?></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <th>ECG</th>
                    <td><?php
                        $total += @$today_report->ecg_cancelled + $today_report->ecg_count;
                        echo @$today_report->ecg_cancelled + $today_report->ecg_count ?></td>
                    <td><?php
                        $cancelled += @$today_report->ecg_cancelled;
                        echo @$today_report->ecg_cancelled ?></td>
                    <td><?php
                        $confirmed += @$today_report->ecg_count;
                        echo @$today_report->ecg_count ?></td>
                    <td><?php
                        $discount_count += @$today_report->ecg_discount_count;
                        $discount += @$today_report->ecg_discount;
                        echo @$today_report->ecg_discount_count ?>
                      -<?php echo @$today_report->ecg_discount ?></td>
                    <td><?php
                        $total_rs += @$today_report->ecg;
                        echo @$today_report->ecg ?></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <th>X-RAY</th>
                    <td><?php
                        $total += @$today_report->x_ray_cancelled + $today_report->x_ray_count;
                        echo @$today_report->x_ray_cancelled + $today_report->x_ray_count ?></td>
                    <td><?php
                        $cancelled += @$today_report->x_ray_cancelled;
                        echo @$today_report->x_ray_cancelled ?></td>
                    <td><?php
                        $confirmed += @$today_report->x_ray_count;
                        echo @$today_report->x_ray_count ?></td>
                    <td><?php
                        $discount_count += @$today_report->x_ray_discount_count;
                        $discount += @$today_report->x_ray_discount;
                        echo @$today_report->x_ray_discount_count ?>
                      -<?php echo @$today_report->x_ray_discount ?></td>
                    <td><?php
                        $total_rs += @$today_report->x_ray;
                        echo @$today_report->x_ray ?></td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <th>ULTRASOUND</th>
                    <td><?php
                        $total += @$today_report->ultrasound_cancelled + $today_report->ultrasound_count;
                        echo @$today_report->ultrasound_cancelled + $today_report->ultrasound_count ?></td>
                    <td><?php
                        $cancelled += @$today_report->ultrasound_cancelled;
                        echo @$today_report->ultrasound_cancelled ?></td>
                    <td><?php
                        $confirmed += @$today_report->ultrasound_count;
                        echo @$today_report->ultrasound_count ?></td>
                    <td><?php
                        $discount_count += @$today_report->ultrasound_discount_count;
                        $discount += @$today_report->ultrasound_discount;
                        echo @$today_report->ultrasound_discount_count ?>
                      -<?php echo @$today_report->ultrasound_discount ?></td>
                    <td><?php
                        $total_rs += @$today_report->ultrasound;
                        echo @$today_report->ultrasound ?></td>
                  </tr>

                  <tr>
                    <td>5</td>
                    <th>Dr. Naila</th>
                    <td><?php
                        $total += @$today_report->dr_naila_cancelled + $today_report->dr_naila_count;
                        echo @$today_report->dr_naila_cancelled + $today_report->dr_naila_count ?></td>
                    <td><?php
                        $cancelled += @$today_report->dr_naila_cancelled;
                        echo @$today_report->dr_naila_cancelled ?></td>
                    <td><?php
                        $confirmed += @$today_report->dr_naila_count;
                        echo @$today_report->dr_naila_count ?></td>
                    <td><?php
                        $discount_count += @$today_report->dr_naila_discount_count;
                        $discount += @$today_report->dr_naila_discount;
                        echo @$today_report->dr_naila_discount_count ?>
                      -<?php echo @$today_report->dr_naila_discount ?></td>
                    <td><?php
                        $total_rs += @$today_report->dr_naila;
                        echo @$today_report->dr_naila ?></td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <th>Dr. Shabana</th>
                    <td><?php
                        $total += @$today_report->dr_shabana_cancelled + $today_report->dr_shabana_count;
                        echo @$today_report->dr_shabana_cancelled + $today_report->dr_shabana_count ?></td>
                    <td><?php
                        $cancelled += @$today_report->dr_shabana_cancelled;
                        echo @$today_report->dr_shabana_cancelled ?></td>
                    <td><?php
                        $confirmed += @$today_report->dr_shabana_count;
                        echo @$today_report->dr_shabana_count ?></td>
                    <td><?php
                        $discount_count += @$today_report->dr_shabana_discount_count;
                        $discount += @$today_report->dr_shabana_discount;
                        echo @$today_report->dr_shabana_discount_count ?>
                      -<?php echo @$today_report->dr_shabana_discount ?></td>
                    <td><?php
                        $total_rs += @$today_report->dr_shabana;
                        echo @$today_report->dr_shabana ?></td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <th>US-Doppler (Dr.Shabana)</th>
                    <td><?php
                        $total += @$today_report->dr_shabana_us_doppler_cancelled + $today_report->dr_shabana_us_doppler_count;
                        echo @$today_report->dr_shabana_us_doppler_cancelled + $today_report->dr_shabana_us_doppler_count ?></td>
                    <td><?php
                        $cancelled += @$today_report->dr_shabana_us_doppler_cancelled;
                        echo @$today_report->dr_shabana_us_doppler_cancelled ?></td>
                    <td><?php
                        $confirmed += @$today_report->dr_shabana_us_doppler_count;
                        echo @$today_report->dr_shabana_us_doppler_count ?></td>
                    <td><?php
                        $discount_count += @$today_report->dr_shabana_us_doppler_discount_count;
                        $discount += @$today_report->dr_shabana_us_doppler_discount;
                        echo @$today_report->dr_shabana_us_doppler_discount_count ?>
                      -<?php echo @$today_report->dr_shabana_us_doppler_discount ?></td>
                    <td><?php
                        $total_rs += @$today_report->dr_shabana_us_doppler;
                        echo @$today_report->dr_shabana_us_doppler ?></td>
                  </tr>
                  <tr>
                    <th colspan="2" style="text-align: right;">Total</th>
                    <th> <?php echo $total; ?></th>
                    <th><?php echo $cancelled ?></th>
                    <td><?php echo $confirmed ?></td>
                    <td><?php echo $discount_count ?>
                      -<?php echo $discount ?></td>
                    <td><?php echo number_format($total_rs); ?></td>
                  </tr>

                </tbody>
              </table>
              <table class="table table-bordered">
                <tr>
                  <td>
                    <h5>Total Expense</h5>
                  </td>
                  <td>
                    <h5><strong><?php echo "Rs " . $today_total_expenses; ?></h5></strong>
                  </td>
                </tr>
              </table>
              <h4>Today Expenses</h4>
              <div>
                <table class="table table-bordered">
                  <tr>
                    <td>#</td>
                    <td>Expense Type</td>
                    <td>Total Expense</td>
                  </tr>
                  <?php
                  $total_expense = 0;
                  $count = 1;
                  foreach ($today_expenses as $expense_type) {
                    $total_expense += $expense_type->expense_total;
                  ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo ucwords(strtolower($expense_type->expense_type)); ?></td>
                      <td><?php echo $expense_type->expense_total ?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <th colspan="2">Total</th>
                    <th><?php echo $total_expense ?></th>
                  </tr>
                </table>
              </div>


              <table class="table table-bordered">
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
                foreach ($today_OPD_reports as $report) { ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $report->test_group_name; ?></td>
                    <td><?php echo $report->total_count + $report->total_receipt_cancelled; ?></td>
                    <td><?php echo $report->total_receipt_cancelled; ?></td>
                    <td><?php echo $report->total_count; ?></td>
                    <td><?php echo $report->total_dis_count; ?> - <?php echo $report->total_discount; ?></td>

                    <td><?php echo $report->total_sum; ?></td>
                  </tr>
                <?php } ?>
                <tr>
                  <th colspan="2" style="text-align: right;">OPD Total</th>
                  <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_count + $today_total_OPD_reports[0]->total_receipt_cancelled ?></th>
                  <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_receipt_cancelled; ?></th>
                  <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_count ?></th>
                  <td><?php echo $today_total_OPD_reports[0]->total_dis_count; ?> - <?php echo $today_total_OPD_reports[0]->total_discount; ?></td>

                  <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_sum ?></th>
                </tr>
              </table>

            </h6>

          </div>
        </div>
      </div>





      <div class="col-md-6">
        <div class="box border blue" id="messenger">
          <div class="box-title">
            <h4><i class="fa fa-bar-chart"></i>This Month Catagories Wise Report</h4>
          </div>
          <div class="box-body">
            <?php
            $total = 0;
            $cancelled = 0;
            $confirmed = 0;
            $discount_count = 0;
            $discount = 0;
            $total_rs = 0;
            ?>
            <h6>
              <table class="table table-bordered" id="today_categories_wise_report">
                <thead>

                  <tr>
                    <th>#</th>
                    <th>Catagories</th>
                    <th>Total</th>
                    <th>Cancelled</th>
                    <th>Confirmed</th>
                    <th>Discounts</th>
                    <th>Total Rs</th>
                  </tr>

                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <th>LAB</th>
                    <td><?php
                        $total += $this_month_report->lab_cancelled + $this_month_report->lab_count;
                        echo $this_month_report->lab_cancelled + $this_month_report->lab_count ?></td>
                    <td><?php
                        $cancelled += $this_month_report->lab_cancelled;
                        echo $this_month_report->lab_cancelled ?></td>
                    <td><?php
                        $confirmed += $this_month_report->lab_count;
                        echo $this_month_report->lab_count ?></td>
                    <td><?php
                        $discount_count += $this_month_report->lab_discount_count;
                        $discount += $this_month_report->lab_discount;
                        echo $this_month_report->lab_discount_count ?>
                      -<?php echo $this_month_report->lab_discount ?></td>
                    <td><?php
                        $total_rs += $this_month_report->lab;
                        echo $this_month_report->lab ?></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <th>ECG</th>
                    <td><?php
                        $total += $this_month_report->ecg_cancelled + $this_month_report->ecg_count;
                        echo $this_month_report->ecg_cancelled + $this_month_report->ecg_count ?></td>
                    <td><?php
                        $cancelled += $this_month_report->ecg_cancelled;
                        echo $this_month_report->ecg_cancelled ?></td>
                    <td><?php
                        $confirmed += $this_month_report->ecg_count;
                        echo $this_month_report->ecg_count ?></td>
                    <td><?php
                        $discount_count += $this_month_report->ecg_discount_count;
                        $discount += $this_month_report->ecg_discount;
                        echo $this_month_report->ecg_discount_count ?>
                      -<?php echo $this_month_report->ecg_discount ?></td>
                    <td><?php
                        $total_rs += $this_month_report->ecg;
                        echo $this_month_report->ecg ?></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <th>X-RAY</th>
                    <td><?php
                        $total += $this_month_report->x_ray_cancelled + $this_month_report->x_ray_count;
                        echo $this_month_report->x_ray_cancelled + $this_month_report->x_ray_count ?></td>
                    <td><?php
                        $cancelled += $this_month_report->x_ray_cancelled;
                        echo $this_month_report->x_ray_cancelled ?></td>
                    <td><?php
                        $confirmed += $this_month_report->x_ray_count;
                        echo $this_month_report->x_ray_count ?></td>
                    <td><?php
                        $discount_count += $this_month_report->x_ray_discount_count;
                        $discount += $this_month_report->x_ray_discount;
                        echo $this_month_report->x_ray_discount_count ?>
                      -<?php echo $this_month_report->x_ray_discount ?></td>
                    <td><?php
                        $total_rs += $this_month_report->x_ray;
                        echo $this_month_report->x_ray ?></td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <th>ULTRASOUND</th>
                    <td><?php
                        $total += $this_month_report->ultrasound_cancelled + $this_month_report->ultrasound_count;
                        echo $this_month_report->ultrasound_cancelled + $this_month_report->ultrasound_count ?></td>
                    <td><?php
                        $cancelled += $this_month_report->ultrasound_cancelled;
                        echo $this_month_report->ultrasound_cancelled ?></td>
                    <td><?php
                        $confirmed += $this_month_report->ultrasound_count;
                        echo $this_month_report->ultrasound_count ?></td>
                    <td><?php
                        $discount_count += $this_month_report->ultrasound_discount_count;
                        $discount += $this_month_report->ultrasound_discount;
                        echo $this_month_report->ultrasound_discount_count ?>
                      -<?php echo $this_month_report->ultrasound_discount ?></td>
                    <td><?php
                        $total_rs += $this_month_report->ultrasound;
                        echo $this_month_report->ultrasound ?></td>
                  </tr>

                  <tr>
                    <td>5</td>
                    <th>Dr. Naila</th>
                    <td><?php
                        $total += $this_month_report->dr_naila_cancelled + $this_month_report->dr_naila_count;
                        echo $this_month_report->dr_naila_cancelled + $this_month_report->dr_naila_count ?></td>
                    <td><?php
                        $cancelled += $this_month_report->dr_naila_cancelled;
                        echo $this_month_report->dr_naila_cancelled ?></td>
                    <td><?php
                        $confirmed += $this_month_report->dr_naila_count;
                        echo $this_month_report->dr_naila_count ?></td>
                    <td><?php
                        $discount_count += $this_month_report->dr_naila_discount_count;
                        $discount += $this_month_report->dr_naila_discount;
                        echo $this_month_report->dr_naila_discount_count ?>
                      -<?php echo $this_month_report->dr_naila_discount ?></td>
                    <td><?php
                        $total_rs += $this_month_report->dr_naila;
                        echo $this_month_report->dr_naila ?></td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <th>Dr. Shabana</th>
                    <td><?php
                        $total += $this_month_report->dr_shabana_cancelled + $this_month_report->dr_shabana_count;
                        echo $this_month_report->dr_shabana_cancelled + $this_month_report->dr_shabana_count ?></td>
                    <td><?php
                        $cancelled += $this_month_report->dr_shabana_cancelled;
                        echo $this_month_report->dr_shabana_cancelled ?></td>
                    <td><?php
                        $confirmed += $this_month_report->dr_shabana_count;
                        echo $this_month_report->dr_shabana_count ?></td>
                    <td><?php
                        $discount_count += $this_month_report->dr_shabana_discount_count;
                        $discount += $this_month_report->dr_shabana_discount;
                        echo $this_month_report->dr_shabana_discount_count ?>
                      -<?php echo $this_month_report->dr_shabana_discount ?></td>
                    <td><?php
                        $total_rs += $this_month_report->dr_shabana;
                        echo $this_month_report->dr_shabana ?></td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <th>US-Doppler (Dr.Shabana)</th>
                    <td><?php
                        $total += $this_month_report->dr_shabana_us_doppler_cancelled + $this_month_report->dr_shabana_us_doppler_count;
                        echo $this_month_report->dr_shabana_us_doppler_cancelled + $this_month_report->dr_shabana_us_doppler_count ?></td>
                    <td><?php
                        $cancelled += $this_month_report->dr_shabana_us_doppler_cancelled;
                        echo $this_month_report->dr_shabana_us_doppler_cancelled ?></td>
                    <td><?php
                        $confirmed += $this_month_report->dr_shabana_us_doppler_count;
                        echo $this_month_report->dr_shabana_us_doppler_count ?></td>
                    <td><?php
                        $discount_count += $this_month_report->dr_shabana_us_doppler_discount_count;
                        $discount += $this_month_report->dr_shabana_us_doppler_discount;
                        echo $this_month_report->dr_shabana_us_doppler_discount_count ?>
                      -<?php echo $this_month_report->dr_shabana_us_doppler_discount ?></td>
                    <td><?php
                        $total_rs += $this_month_report->dr_shabana_us_doppler;
                        echo $this_month_report->dr_shabana_us_doppler ?></td>
                  </tr>
                  <tr>
                    <th colspan="2" style="text-align: right;">Total</th>
                    <th> <?php echo $total; ?></th>
                    <th><?php echo $cancelled ?></th>
                    <td><?php echo $confirmed ?></td>
                    <td><?php echo $discount_count ?>
                      -<?php echo $discount ?></td>
                    <td><?php echo number_format($total_rs); ?></td>
                  </tr>

                </tbody>
              </table>
              <table class="table table-bordered">
                <tr>
                  <td>
                    <h5>This Month Expense</h5>
                  </td>
                  <td>
                    <h5><strong><?php echo "Rs " . $this_month_total_expenses; ?></h5></strong>
                  </td>
                </tr>
              </table>
              <h4>This Month Expenses</h4>
              <div>
                <table class="table table-bordered">
                  <tr>
                    <td>#</td>
                    <td>Expense Type</td>
                    <td>Total Expense</td>
                  </tr>
                  <?php
                  $this_month_total_expense = 0;
                  $count = 1;
                  foreach ($this_month_expenses as $expense_type) {
                    $total_expense += $expense_type->expense_total;
                  ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo ucwords(strtolower($expense_type->expense_type)); ?></td>
                      <td><?php echo $expense_type->expense_total ?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <th colspan="2">Total</th>
                    <th><?php echo $this_month_total_expense ?></th>
                  </tr>
                </table>
              </div>
              <table class="table table-bordered">
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
                    <td><?php echo $report->test_group_name; ?></td>
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
            </h6>
          </div>
        </div>
      </div>






    </div>

    <div class="col-md-12">
      <div class="box border blue" id="messenger">
        <div class="box-title">
          <h4 class="pull-left">Current Month Day Wise Report</h4>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-8">
              <div id="current_month_report"></div>
              <h2>Current Month Day Wise Report</h2>
              <div style="overflow-x:auto;">
                <table class="table table-bordered">


                  <tr>
                    <th>Date</th>
                    <th>LAB</th>
                    <th>ECG</th>
                    <th>X-RAY</th>
                    <th>UltaS</th>
                    <th>Dr.Naila</th>
                    <th>Dr.Shabana</th>
                    <th>US-Doppler(Sh.)</th>


                    <th>Discounts.</th>
                    <th>Discount Rs</th>
                    <th>Income</th>
                    <th>Expense</th>
                    <th>Profit</th>

                  </tr>
                  <?php
                  $count = 0;
                  $total_income = 0;

                  $day_wise_monthly_report_array = $day_wise_monthly_report;
                  krsort($day_wise_monthly_report_array);
                  foreach ($day_wise_monthly_report_array as $date => $report) {
                    $total_income += @$report->total; ?>
                    <tr <?php if ($count == 0) { ?> style="back ground-color:#9F9 !important; " <?php $count++;
                                                                                              } ?>>
                      <td><?php echo $date; ?></td>
                      <td><?php echo @$report->lab ?></td>
                      <td><?php echo @$report->ecg ?></td>
                      <td><?php echo @$report->x_ray ?></td>
                      <td><?php echo @$report->ultrasound ?></td>
                      <td><?php echo @$report->dr_naila ?></td>
                      <td><?php echo @$report->dr_shabana ?></td>
                      <td><?php echo @$report->dr_shabana_us_doppler ?></td>

                      <td><?php echo @$report->discount_count; ?></td>
                      <td><?php echo @$report->discount; ?></td>
                      <td><?php echo @$report->total; ?></td>
                      <td><?php echo @$report->expense; ?></td>
                      <td><?php echo @($report->total - $report->expense); ?></td>



                    </tr>
                  <?php } ?>
                </table>
              </div>

            </div>
            <div class="hidden-xs col-md-4">

              <h4>All Lab Tests</h4>

              <?php
              foreach ($this_month_tests as $test_category) { ?>
                <h5><?php echo $test_category->test_category; ?> </h5>
                <table class="table table-bordered">
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
                      <td><?php echo $this_month_test->test_name  ?></td>
                      <td><?php echo $this_month_test->test_total ?></td>
                      <td><?php echo $this_month_test->total_rs ?></td>
                    </tr>
                  <?php } ?>

                </table>
              <?php } ?>
            </div>






          </div>
        </div>
      </div>
    </div>



    <div class="col-md-12">
      <div class="box border blue" id="messenger">
        <div class="box-title">
          <h4 class="pull-left">Current Year Monthly Report</h4>
        </div>
        <div class="box-body">
          <div class="row">

            <div class="col-md-8">
              <h2>Current Year Monthly Report</h2>
              <div style="overflow-x:auto;">
                <table class="table table-bordered">


                  <tr>
                    <th>Date</th>
                    <th>LAB</th>
                    <th>ECG</th>
                    <th>X-RAY</th>
                    <th>UltaS</th>
                    <th>Dr.Naila</th>
                    <th>Dr.Shabana</th>
                    <th>US-Doppler(Sh.)</th>


                    <th>Discounts.</th>
                    <th>Discount Rs</th>
                    <th>Income</th>
                    <th>Expense</th>
                    <th>Profit</th>

                  </tr>
                  <?php
                  $count = 0;
                  $total_income = 0;

                  foreach ($month_wise_yearly_report as $date => $report) {
                    $total_income += @$report->total; ?>
                    <tr <?php if ($count == 0) { ?> style="back ground-color:#9F9 !important; " <?php $count++;
                                                                                              } ?>>
                      <td><?php echo $date; ?></td>
                      <td><?php echo @$report->lab ?></td>
                      <td><?php echo @$report->ecg ?></td>
                      <td><?php echo @$report->x_ray ?></td>
                      <td><?php echo @$report->ultrasound ?></td>
                      <td><?php echo @$report->dr_naila ?></td>
                      <td><?php echo @$report->dr_shabana ?></td>
                      <td><?php echo @$report->dr_shabana_us_doppler ?></td>

                      <td><?php echo @$report->discount_count; ?></td>
                      <td><?php echo @$report->discount; ?></td>
                      <td><?php echo @$report->total; ?></td>
                      <td><?php echo @$report->expense; ?></td>
                      <td><?php echo @($report->total - $report->expense); ?></td>



                    </tr>
                  <?php } ?>
                </table>
              </div>

            </div>

            <div class="hidden-xs col-md-4">
              <div id="year_monthly_report"></div>
            </div>



          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box border blue" id="messenger">
        <div class="box-title">
          <h4 class="pull-left">Annual Report</h4>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="hidden-xs col-md-4">
              <div id="year_report"></div>
            </div>
            <div class="col-md-8">
              <h2>Annual Report</h2>
              <div style="overflow-x:auto;">
                <table class="table table-bordered">


                  <tr>
                    <th>Date</th>
                    <th>LAB</th>
                    <th>ECG</th>
                    <th>X-RAY</th>
                    <th>UltaS</th>
                    <th>Dr.Naila</th>
                    <th>Dr.Shabana</th>
                    <th>US-Doppler(Sh.)</th>


                    <th>Discounts.</th>
                    <th>Discount Rs</th>
                    <th>Income</th>
                    <th>Expense</th>
                    <th>Profit</th>

                  </tr>
                  <?php
                  $count = 0;
                  $total_income = 0;

                  foreach ($yearly_report as $date => $report) {
                    $total_income += @$report->total; ?>
                    <tr <?php if ($count == 0) { ?> style="back ground-color:#9F9 !important; " <?php $count++;
                                                                                              } ?>>
                      <td><?php echo $date; ?></td>
                      <td><?php echo @$report->lab ?></td>
                      <td><?php echo @$report->ecg ?></td>
                      <td><?php echo @$report->x_ray ?></td>
                      <td><?php echo @$report->ultrasound ?></td>
                      <td><?php echo @$report->dr_naila ?></td>
                      <td><?php echo @$report->dr_shabana ?></td>
                      <td><?php echo @$report->dr_shabana_us_doppler ?></td>

                      <td><?php echo @$report->discount_count; ?></td>
                      <td><?php echo @$report->discount; ?></td>
                      <td><?php echo @$report->total; ?></td>
                      <td><?php echo @$report->expense; ?></td>
                      <td><?php echo @($report->total - $report->expense); ?></td>



                    </tr>
                  <?php } ?>
                </table>
              </div>

            </div>





          </div>
        </div>
      </div>
    </div>


  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#year_monthly_report').highcharts({
      title: {
        text: 'Current Year Monthly Report',
        x: -20 //center
      },
      subtitle: {
        text: 'Current Year Monthly Report',
        x: -20
      },
      xAxis: {
        categories: [
          <?php
          $income = "";
          foreach ($month_wise_yearly_report as $date => $report) {
            if (@$report->total) {
              $income .= @$report->total . ", ";
            } else {
              $income .= "0, ";
            }
          ?> '<?php echo $date; ?>',
          <?php } ?>
        ]
      },
      yAxis: {
        title: {
          text: 'Income / Expenses'
        },
        plotLines: [{
          value: 0,
          width: 1,
          color: '#808080'
        }]
      },
      tooltip: {
        valueSuffix: ' Total'
      },
      // legend: {
      //   layout: 'vertical',
      //   align: 'right',
      //   verticalAlign: 'middle',
      //   borderWidth: 0
      // },
      series: [{
          name: 'Incomes',
          data: [<?php echo $income; ?>]
        }

      ]
    });
  });



  $(function() {
    $('#current_month_report').highcharts({
      title: {
        text: 'Current Month ',
        x: -20 //center
      },
      subtitle: {
        text: 'Current Month Days Wise Report',
        x: -20
      },
      xAxis: {
        categories: [
          <?php
          $income = "";
          foreach ($day_wise_monthly_report as $date => $report) {
            if (@$report->total) {
              $income .= @$report->total . ", ";
            } else {
              $income .= "0, ";
            }

          ?> '<?php echo $date; ?>',
          <?php } ?>
        ]
      },
      yAxis: {
        title: {
          text: 'Income'
        },
        plotLines: [{
          value: 0,
          width: 1,
          color: '#808080'
        }]
      },
      tooltip: {
        valueSuffix: ' Total'
      },
      // legend: {
      //   layout: 'vertical',
      //   align: 'right',
      //   verticalAlign: 'middle',
      //   borderWidth: 0
      // },
      series: [{
          name: 'Incomes',
          data: [<?php echo $income; ?>]
        }

      ]
    });
  });



  $(function() {
    $('#year_report').highcharts({
      title: {
        text: 'Annual Report',
        x: -20 //center
      },
      subtitle: {
        text: 'Annual Report',
        x: -20
      },
      xAxis: {
        categories: [<?php
                      $income = "";
                      foreach ($yearly_report  as $date => $report) {
                        if (@$report->total) {
                          $income .= @$report->total . ", ";
                        } else {
                          $income .= "0, ";
                        }

                      ?> '<?php echo $date; ?>',
          <?php } ?>
        ]
      },
      yAxis: {
        title: {
          text: 'Income'
        },
        plotLines: [{
          value: 0,
          width: 1,
          color: '#808080'
        }]
      },
      tooltip: {
        valueSuffix: ' Total'
      },
      // legend: {
      //   layout: 'vertical',
      //   align: 'right',
      //   verticalAlign: 'middle',
      //   borderWidth: 0
      // },
      series: [{
          name: 'Incomes',
          data: [<?php echo $income; ?>]
        }

      ]
    });
  });
</script>
<style>
  .table-bordered {
    border: 1px solid #ddd;
    font-size: smaller !important;
  }
</style>
<script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/Highcharts/js/highcharts.js"></script>
<script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/Highcharts/js/highcharts-more.js"></script>
<script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/Highcharts/js/modules/exporting.js"></script>
<script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/Highcharts/js/modules/drilldown.js"></script>