<!doctype html>
<html>

<head>
  <title>Receipt</title>
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
      font-family: Calibri, sans-serif;
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
        border: 1px solid black;
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
        font-size: 15px !important;
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
      font-size: 15px !important;
      color: black !important;
      border: 1px solid black;
    }
  </style>
</head>

<body>
  <page size='A4' style="font-size: 9px !important; color: black !important;">
    <div style="padding: 0px;" contenteditable="tr ue">
      <div style="text-align: center; padding-top: 10px;">
        <h4>Tareen Infertility & Impotence Center Peshawar</h4>
        <small style="font-size: 12px;">Liberty Mall Opp: Air Port Runway, University Rd, Tahkal, Peshawar, Khyber Pakhtunkhwa 25000
          <br /> PHONE 0000-000000</small>
        <br />
        <strong style="font-size: 12px;">RECEIPT NO: <?php echo $invoice_detail->invoice_id; ?> <br /> Token NO: <?php echo $invoice_detail->test_token_id; ?></strong>

      </div>

      <table style="width: 100%;">
        <thead>
          <tr>
            <td style="text-align: center;">
              <table style="width: 100%; margin-top: 10px;">
                <tr>
                  <td>

                    <div style="border: 1px dashed black; margin: 5px; padding:5px">
                      <table style="text-align: left; width:100%; font-size: 12px !important;">
                        <tr>
                          <th>Patient Name: </th>
                          <td><?php echo trim(ucwords(strtolower($invoice_detail->patient_name))); ?></td>
                        </tr>
                        <tr>
                          <th>Mobile No:</th>
                          <td><?php echo $invoice_detail->patient_mobile_no; ?></td>
                        </tr>
                        <tr>
                          <th>Gender: <?php echo $invoice_detail->patient_gender; ?></th>
                          <th>Age: <?php echo @$invoice_detail->patient_age; ?> Y</th>
                        </tr>

                        <tr>
                          <th>Address</th>
                          <td><?php echo trim(ucwords(strtolower($invoice_detail->patient_address))); ?></td>
                        </tr>


                        <tr>
                          <th>Refereed By:</th>
                          <td><?php echo str_replace("Muhammad", "M.", $invoice_detail->doctor_name) . "( " . $invoice_detail->doctor_designation . " )"; ?></td>
                        </tr>
                        <tr>
                          <th>Date & Time:</th>
                          <td><?php echo date("d F, Y h:i:s", strtotime($invoice_detail->created_date)); ?></td>
                        </tr>
                      </table>
                    </div>
                  </td>

                </tr>

                <tr>
                  <td>

                    <div style="margin: 5px; padding:5px; ">
                      <table class="table table-bordered" style="text-align: left; font-size: 15px !important;">
                        <tr>
                          <th>#</th>
                          <th>Details</th>
                          <th>Amount</th>
                        </tr>
                        <?php
                        $count = 1;
                        foreach ($invoice->invoice_details as $invoicedetail) { ?>
                          <tr>
                            <th><?php echo $count++; ?></th>
                            <td><?php echo $invoicedetail->test_group_name; ?></td>
                            <td><?php echo $invoicedetail->price; ?></td>
                          </tr>
                        <?php } ?>
                        <tr>
                          <th colspan="3" style="text-align: right;">Total: <?php echo $invoice->price; ?> Rs <br />
                            Discount: <?php echo $invoice->discount; ?> Rs <br />
                            Total: <?php echo $invoice->total_price; ?> Rs
                          </th>
                        </tr>

                      </table>

                    </div>
                  </td>
                </tr>
              </table>
              </th>
          </tr>
        </thead>

      </table>
    </div>

  </page>
</body>



</html>