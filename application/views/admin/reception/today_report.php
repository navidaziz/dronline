<div class="row">
  <div>
    <form action="<?php echo site_url(ADMIN_DIR . 'reports/daily_reception_report') ?>" method="get" target="new">
      <input type="date" name="date" value="<?php echo date("Y-m-d"); ?>" />
      <input type="submit" value="Print Report" name="Print Report" />
    </form>

    <!-- <a target="new" class="btn btn-primary" href="<?php echo site_url(ADMIN_DIR . "reports/daily_reception_report") ?>">Print Today Report</a> -->
  </div>
  <br />
  <!-- MESSENGER -->
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bar-chart"></i>Today Categories Wise Report</h4>
      </div>
      <div class="box-body">
        <table class="table table-bordered" id="today_categories_wise_report">
          <thead>

            <tr>
              <th>#</th>
              <th>Categories</th>
              <th>Total</th>
              <th>Cancelled</th>
              <th>Confirmed</th>
              <th>Discounts</th>
              <th>Total Rs</th>
            </tr>

          </thead>
          <tbody>

            <?php
            $count = 1;
            foreach ($today_cat_wise_progress_reports as $report) { ?>
              <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $report->test_category; ?></td>
                <td><?php echo $report->total_count + $report->total_receipt_cancelled; ?></td>
                <td><?php echo $report->total_receipt_cancelled; ?></td>
                <td><?php echo $report->total_count; ?></td>
                <td><?php echo $report->total_dis_count; ?> - <?php echo $report->total_discount; ?></td>
                <td><?php echo $report->total_sum; ?></td>
              </tr>
            <?php } ?>
            <tr>
              <th colspan="2" style="text-align: right;">Total</th>
              <th style="text-align: center;"><?php echo $today_total_cat_wise_progress_reports[0]->total_count + $today_total_cat_wise_progress_reports[0]->total_receipt_cancelled ?></th>
              <th style="text-align: center;"><?php echo $today_total_cat_wise_progress_reports[0]->total_receipt_cancelled; ?></th>
              <th style="text-align: center;"><?php echo $today_total_cat_wise_progress_reports[0]->total_count ?></th>
              <td><?php echo $today_total_cat_wise_progress_reports[0]->total_dis_count; ?> - <?php echo $today_total_cat_wise_progress_reports[0]->total_discount; ?></td>
              <th style="text-align: center;"><?php echo $today_total_cat_wise_progress_reports[0]->total_sum ?></th>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered">
          <tr>
            <th>#</th>
            <th>Doctor Name</th>
            <th>Total</th>
            <th>Cancelled</th>
            <th>Confirmed</th>
            <th>Discount</th>
            <th>Total RS</th>
          </tr>
          <?php
          $count = 1;
          $total_income_from_drs = 0;
          foreach ($income_from_drs as $report) { ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $report->test_group_name; ?></td>
              <td><?php echo $report->total_count + $report->total_receipt_cancelled; ?></td>
              <td><?php echo $report->total_receipt_cancelled; ?></td>
              <td><?php echo $report->total_count; ?></td>
              <td><?php echo $report->total_dis_count; ?> - <?php echo $report->total_discount; ?></td>
              <th style="text-align: center;"><?php echo $report->shares;
                                              $total_income_from_drs += $report->shares;
                                              ?></th>
            </tr>
          <?php } ?>
          <tr>
            <th colspan="6" style="text-align: right;">Total</th>

            <th style="text-align: center;">

              <?php echo $total_income_from_drs; ?></th>
          </tr>
        </table>
        <h4><?php echo "Total " . $today_total_cat_wise_progress_reports[0]->total_sum . ' + ' . $total_income_from_drs . ' = ' . ($today_total_cat_wise_progress_reports[0]->total_sum + $total_income_from_drs) . ' Rs'; ?></h4>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user-md"></i>Today OPD Wise Report</h4>
      </div>
      <div class="box-body">
        <table class="table table-bordered">
          <tr>
            <th>#</th>
            <th>Doctor Name</th>
            <th>Total Appointments</th>
            <th>Cancelled</th>
            <th>Confirmed</th>
            <th>Discount</th>
            <th>Dr. Total</th>
            <th>Shares Total</th>
            <th>Total Rs</th>
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
              <td>
                <?php echo $report->total_sum - $report->shares; ?>
              </td>
              <td>
                <?php echo $report->shares; ?>
              </td>
              <td><?php echo $report->total_sum; ?></td>
            </tr>
          <?php } ?>
          <tr>
            <th colspan="2" style="text-align: right;">OPD Total</th>
            <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_count + $today_total_OPD_reports[0]->total_receipt_cancelled ?></th>
            <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_receipt_cancelled; ?></th>
            <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_count ?></th>
            <td><?php echo $today_total_OPD_reports[0]->total_dis_count; ?> - <?php echo $today_total_OPD_reports[0]->total_discount; ?></td>
            <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_sum - $today_total_OPD_reports[0]->shares ?></th>
            <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->shares ?></th>
            <th style="text-align: center;"><?php echo $today_total_OPD_reports[0]->total_sum ?></th>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>