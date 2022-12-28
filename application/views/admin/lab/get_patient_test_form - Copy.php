
<div class="pull-left" >
<table>
<tr><th>Patient Name: </th><td><?php echo $invoice_detail->patient_name; ?></td></tr>
<tr><th>Gender:</th><td><?php echo $invoice_detail->patient_gender; ?></td></tr>
<tr><th>Mobile No:</th><td><?php echo $invoice_detail->patient_mobile_no; ?></td></tr>
<tr><th>Address</th><td><?php echo $invoice_detail->patient_address; ?></td></tr>


</table>
</div>
<div class="pull-right" >
<table>
<tr><th>Invoice No:</th><td><?php echo $invoice_detail->invoice_id; ?></td></tr>
<tr><th>Test Token No.</th><td><?php echo $invoice_detail->test_token_id; ?></td></tr>
<tr><th>Refered By:</th><td><?php echo $invoice_detail->doctor_name."( ".$invoice_detail->doctor_designation." )"; ?></td></tr>
<tr><th>Registered:</th><td><?php echo get_timeago($invoice_detail->created_date); ?></td></tr>

</table>
</div>
<div style="clear:both; display:block; margin-bottom:10px;"></div>

<table class="table">
<tr><th>#</th><th>Test Name</th> <th>Test Result</th> <th>Normal Value</th> <th>Remarks</th></tr>
<?php 
$count =1;
foreach($patient_tests as $patient_test){ ?>
<tr><td><?php echo $count++; ?></td>
<td><?php echo $patient_test->test_name; ?></td>
<td><input onkeyup="update_test_value('<?php echo $patient_test->patient_test_id; ?>')" type="text" id="test_<?php echo $patient_test->patient_test_id; ?>_value" value="<?php echo $patient_test->test_result; ?>" /></td>
<td><?php echo $patient_test->test_normal_value; ?></td>
<td><input type="text" onkeyup="update_test_remarks('<?php echo $patient_test->patient_test_id; ?>')" id="test_<?php echo $patient_test->patient_test_id; ?>_remark" value="<?php echo $patient_test->remarks; ?>" /></td></tr>
<tr>

<?php } ?>
<td colspan="5" style="text-align:center">
<form action="<?php echo site_url(ADMIN_DIR."lab/complete_test"); ?>" method="post" >
<input type="hidden" value="<?php echo $invoice_detail->invoice_id; ?>" name="invoice_id"  />
<input class="btn btn-success" type="submit" value="Complete Test" name="Complete Test" />
</form>
</td>
</tr>
</table>


<script>
function update_test_value(patient_test_id){
		 
		 
		 var partient_test_value = $('#test_'+patient_test_id+'_value').val();
		$.ajax({
         type: "POST",
         url: "<?php echo site_url(ADMIN_DIR); ?>/lab/update_test_value/",
         data: {patient_test_id:patient_test_id, partient_test_value:partient_test_value}
       }).done(function(data) {
		  // alert(data);
         //console.log(data);
        // $('#patient_test').html(data);
       });
		 }
//partient_test_remark

function update_test_remarks(patient_test_id){
		 
		 
		 var partient_test_remark = $('#test_'+patient_test_id+'_remark').val();
		 //alert(partient_test_remark);
		$.ajax({
         type: "POST",
         url: "<?php echo site_url(ADMIN_DIR); ?>/lab/update_test_remark/",
         data: {patient_test_id:patient_test_id, partient_test_remark:partient_test_remark}
       }).done(function(data) {
		  //alert(data);
         //console.log(data);
        // $('#patient_test').html(data);
       });
		 }		 

</script>