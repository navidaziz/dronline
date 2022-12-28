<!doctype html>
<html>

<head>
  <title>Token No</title>
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />

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
      width: 8cm;
      height: auto;
      font-weight: bold !important;
      font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
      font-size: 12px !important;
    }


    @media print {

      body,
      page {
        margin: 0;
        box-shadow: 0;
        color: black;
      }

      .table-bordered {
        border: 1px solid black !important;
      }

      .table>thead>tr>th,
      .table>tbody>tr>th,
      .table>tfoot>tr>th,
      .table>thead>tr>td,
      .table>tbody>tr>td,
      .table>tfoot>tr>td {
        padding: 3px;
        line-height: 1.628571;
        vertical-align: top;
        border-top: 1px solid #ddd;
        color: black !important;
        border: 1px solid black;
      }

    }


    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      padding: 3px;
      line-height: 1.628571;
      vertical-align: top;
      border-top: 1px solid #ddd;
      color: black !important;
      border: 1px solid black;
    }
  </style>
</head>

<body>
  <page size='A4'>



    <table style="width: 99%; margin: 2px; padding:2px; ">
      <thead>
        <tr>
          <td>
            <table style="width: 100%; margin-top: 10px; color:black">

              <tr>
                <td style="text-align: center; font-weight: bold !important;">
                  <h4 style="font-weight: bold !important;">Dr Online</h4>
                  <table class="table">
                    <tr>
                      <td>RECEIPT NO: <?php echo $invoice_detail->invoice_id; ?></td>
                      <td>
                        TOKEN NO:
                        <?php if ($invoice_detail->receipt_print == 0) { ?>
                          <?php echo $invoice_detail->test_token_id; ?>
                        <?php
                          // $query = "UPDATE `invoices` SET `invoices`.`receipt_print`=1 WHERE `invoices`.`invoice_id` = '" . $invoice_detail->invoice_id . "'";
                          // $this->db->query($query);
                        } else { ?>
                          ******<?php echo substr($invoice_detail->test_token_id, -4); ?>

                        <?php } ?>
                      </td>
                    </tr>
                  </table>

                  <h4 style="font-weight: bold !important;">
                    <?php
                    if ($invoice_detail->category_id != 5) {

                      $query = "SELECT test_category FROM test_categories WHERE test_category_id= '" . $invoice_detail->category_id . "'";
                      echo $this->db->query($query)->result()[0]->test_category;
                      echo " - " . $invoice_detail->today_count;
                    } else {
                      $query = "SELECT test_group_name FROM test_groups WHERE test_group_id = '" . $invoice_detail->opd_doctor . "'";
                      $opd_doctor = $this->db->query($query)->result()[0]->test_group_name;

                      echo '<h4 style="font-weight: bold !important;">' . $opd_doctor . '</h4>';

                      echo  "<h2 style='font-weight: bold !important;'>" . $invoice_detail->today_count . "</h2>";
                    }

                    echo '<h4 style="font-weight: bold !important;">' . date("d F, Y ", strtotime($invoice_detail->created_date)) . '</h4>';
                    ?>

                  </h4>

                </td>
              </tr>
              <tr>
                <td>

                  <table width="100%" style="font-size: 15px; font-weight:bold !important;">
                    <tr>
                      <td>Patient ID: </td>
                      <td><?php echo trim(ucwords(strtolower($invoice_detail->patient_id))); ?></td>
                    </tr>
                    <tr>
                      <td>Patient Name: </td>
                      <td><?php echo trim(ucwords(strtolower($invoice_detail->patient_name))); ?></td>
                    </tr>
                    <!-- <tr>
                      <th>History No: </th>
                      <td><?php echo $invoice_detail->history_file_no; ?></td>
                    </tr> -->
                    <tr>
                      <td>Age/Sex:</td>
                      <td><?php echo @$invoice_detail->patient_age; ?> Y / <?php echo $invoice_detail->patient_gender; ?></td>
                    </tr>

                    <tr>
                      <td>Address</td>
                      <td><small><?php echo trim(ucwords(strtolower($invoice_detail->patient_address))); ?></small></td>
                    </tr>

                    <?php if ($invoice_detail->category_id != 5) { ?>
                      <tr>
                        <td>Refereed By:</td>
                        <td><?php echo str_replace("Muhammad", "M.", $invoice_detail->doctor_name) . "( " . $invoice_detail->doctor_designation . " )"; ?></td>
                      </tr>
                    <?php } ?>
                  </table>
                  <br />
                  <br />
                </td>

              </tr>

              <!-- <tr>
                 <td>

                  <h5>
                    <table border="1" width="100%" style="font-weight:bold !important" class="table">
                      <tr>
                        <td>#</td>
                        <td>Details</td>
                        <td>Amount</td>
                      </tr>
                      <?php
                      $count = 1;
                      foreach ($invoice->invoice_details as $invoicedetail) { ?>
                        <tr>
                          <td><?php echo $count++; ?></td>
                          <td>
                            <?php if ($invoice_detail->category_id != 5) { ?>
                              <?php echo $invoicedetail->test_group_name; ?>
                            <?php } else {
                              echo "Consultation Fee";
                            } ?>
                          </td>
                          <td><?php echo $invoicedetail->price; ?></td>
                        </tr>
                      <?php } ?>
                      <tr>
                        <td colspan="2" style="text-align: right;">Total (Rs.)</td>
                        <td style="text-align: center;"><?php echo $invoice->price; ?>.00</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align: right;">Discount (Rs.)</td>
                        <td style="text-align: center;"><?php if ($invoice->discount) {
                                                          echo $invoice->discount;
                                                        } else {
                                                          echo "00";
                                                        }  ?>.00
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align: right;">Total (Rs.)</td>
                        <td style="text-align: center;"><?php echo $invoice->total_price; ?>.00</td>
                      </tr>


                    </table>
                  </h5>
                </td> 
              </tr>-->
            </table>
          </td>
        </tr>
      </thead>

    </table>
    <p style="font-size: smaller; font-weight: initial; text-align: center; color:black">@created
      <?php $query = "SELECT user_title from users WHERE user_id='" . $invoice->created_by . "'";
      echo $this->db->query($query)->result()[0]->user_title;
      $query = "SELECT
                  `roles`.`role_title` 
              FROM `roles`,
              `users` 
              WHERE `roles`.`role_id` = `users`.`role_id`
              AND `users`.`user_id`='" . $invoice->created_by . "'";
      echo " (" . $this->db->query($query)->result()[0]->role_title . ")";
      ?> - <?php echo date("d F, Y h:i:s", strtotime($invoice_detail->created_date)); ?></p>
    </div>

  </page>
</body>



</html>