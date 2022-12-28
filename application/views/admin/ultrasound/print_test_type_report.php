
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
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print" />
  <link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/".ADMIN_DIR); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />
  <link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/".ADMIN_DIR); ?>/css/responsive.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="http://localhost/lab/assets/admin/jstree-dist/themes/default/style.min.css" media="screen,print" />
  <link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/".ADMIN_DIR); ?>/css/custom.css" media="screen,print" />
  

<style>
body {
  background: rgb(204,204,204); 
}
page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
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
  body, page {
    margin: 0;
    box-shadow: 0;
    color:black;
  }
  
}

.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    padding: 8px;
    line-height: 0.628571;
    vertical-align: top;
    border-top: 1px solid #ddd;
    font-size: 15px !important;
    
}
       
       
</style>
</head>
<body  >
<page size='A4'>
<div style="padding: 40px;" contenteditable="true">

<table style="width: 100%;">
      <thead>
        <tr>
          <td>
            <table style="width: 100%; margin-top: 100px;">
                <tr >
                  <td style="width: 45%;">
                  
                    <div style="border: 1px dashed black; margin: 5px; padding:5px">
                        <table  style="text-align: left; width:100%; font-size: 14px !important;">
                        <tr>
                        <th>Patient Name: </th>
                        <td><?php echo trim(ucwords(strtolower($invoice_detail->patient_name))); ?></td>
                        </tr>
                        <tr>
                        <th>Gender:  <?php echo $invoice_detail->patient_gender; ?></th>
                        <th>Age:  <?php echo @$invoice_detail->patient_age; ?> Y</th>
                        </tr>
                        <tr>
                        <th>Mobile No:</th>
                        <td><?php echo $invoice_detail->patient_mobile_no; ?></td>
                        </tr>
                        <tr>
                        <th>Address</th>
                        <td><?php echo trim(ucwords(strtolower($invoice_detail->patient_address))); ?></td>
                        </tr>
                        </table>
                    </div>
                  </td>
                  <td>
                  <div style="border: 1px dashed black; margin: 5px; padding:5px">
                        <table  style="text-align: left; width:100%; font-size: 14px !important;">
                    <tr>
                    <th>Invoice No:</th>
                    <td><?php echo $invoice_detail->invoice_id; ?></td>
                    </tr>
                    <tr>
                    <th>Test Token No.</th>
                    <td><?php echo $invoice_detail->test_token_id; ?></td>
                    </tr>

                    <tr>
                    <th>Refered By:</th>
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
            </table>
          </td>
        </tr>
      </thead>
  <tbody>
    <tr>
      <td>
          <?php foreach ($patient_tests_groups as $patient_tests_group) { ?>
          <h5><strong><?php echo $patient_tests_group->test_group_name; ?></strong></h5>
               <table class="table table-bordered" style="text-align: left; width:100%;">
               <?php 
               $count = 1;
               foreach ($patient_tests_group->patient_tests_types as $patient_tests_type) { 
                 
                $normal_value=true;
                foreach ($patient_tests_type->patient_tests as $patient_test) {
                  if($patient_test->test_normal_value!=""){ $normal_value=true; }else{ $normal_value=false;  }
                }
                $count2=1;
                foreach ($patient_tests_type->patient_tests as $patient_test) {  
                  if($patient_test->test_result!=''){  
                     if($count==1){ ?>
                            <tr>
                                <!-- <th >#</th> -->
                                <th ></th>
                                <th style="width:200px">Test Name</th>
                                <th>Test Result</th>
                                <?php if($normal_value){ ?>
                                <th>Unit</th>
                                <th>Normal Value</th> 
                                <?php }  ?>
                                <!-- <th>Remarks</th> -->
                            </tr>
                            <?php } ?>
                <tr>
                
                
                  
                  <?php if($count2==1){ ?>
                    <th style="width: 250px;" rowspan="<?php echo count($patient_tests_type->patient_tests); ?>" ><h5><strong><?php echo $patient_tests_type->test_type; ?></strong></h5></th>
                    
                  <?php } ?>
                  <!-- <th><?php echo $count++; ?></th> -->
                  <!-- <th><?php echo $count2++; ?></th> -->
                  <th><?php echo $patient_test->test_name; ?></th>
                  
                  <th> <?php echo $patient_test->test_result; ?> </th>
                  
                  <?php if($normal_value){ ?> 
                    <th> <?php echo $patient_test->unit; ?> </th>
                    <th><?php echo $patient_test->test_normal_value; ?></th><?php }  ?>
                  <!-- <td><?php echo $patient_test->remarks; ?> </td> -->
                </tr>
                 <?php } ?>
        <?php } ?>
      
    <?php  } ?>
    </table>
      </td>
    </tr>
    <tr>
      <td>
      <br />
<?php if($invoice_detail->remarks){ ?>
<div style="text-align: left;"><strong>Remarks:</strong>
    <p style="border: 1px dashed #ddd; border-radius: 5px; padding: 5px; min-height: 5px;"><?php echo $invoice_detail->remarks; ?></p>
    </div>
    <?php } 
    }
?>
      </td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td>

    <p class="divFooter" style="text-align: right;"><b>Eid Ullah</b><br />Chitral City Medical <br /> Laboratory Chitral</p>
</td>
    </tr>
  </tfoot>
</table>








  

</div>

</page>
</body>



</html>
