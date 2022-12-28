<?php $this->load->view(ADMIN_DIR."reception/reception_header"); ?>

<div class="row"> 
  <!-- MESSENGER -->
  <div class="col-md-2">
    <div class="box border blue" id="messenger" >
      <div class="box-title">
        <h4><i class="fa fa-forward"></i>Forwarded Tests</h4>
      </div>
      <div class="box-body"  >
        <table class="table">
          <?php foreach($forwarded_tests as $test){ 
	  
	 $other_info = 'Mobile No: '.$test->patient_mobile_no.'<br />';
	 $other_info.= 'Address: '.$test->patient_address.'<br />';
	 $other_info.= 'Refered By: '.$test->doctor_name.' ('.$test->doctor_designation.')<br />';
	 $other_info.='Tests: <strong>';
	 $patient_group_test_ids = '';
	 //get the test groups for the pacient...
	 $query="SELECT
				`test_groups`.`test_group_name`,
				`test_groups`.`test_group_id`
			FROM
			`invoice_test_groups`,
			`test_groups` 
			WHERE `invoice_test_groups`.`test_group_id` = `test_groups`.`test_group_id`
			AND `invoice_test_groups`.`invoice_id` = '".$test->invoice_id."'";
	$query_result = $this->db->query($query);
	$patient_tests = $query_result->result();
	foreach($patient_tests as $patient_test){
		$other_info.= $patient_test->test_group_name.', ';
		$patient_group_test_ids.=$patient_test->test_group_id.', ';
		}	
	$other_info.='</strong>';		
	 
	  ?>
          <tr>
            <td  ><input id="in_<?php echo $test->invoice_id; ?>" type="hidden" value="<?php echo $other_info; ?>" />
              <input id="patient_group_test_ids_<?php echo $test->invoice_id; ?>" type="hidden" value="<?php echo $patient_group_test_ids; ?>" />
              <a href="#" onclick="test_token('<?php echo $test->invoice_id; ?>', '<?php echo $test->patient_name; ?>')" > In#: <?php echo $test->invoice_id; ?> <span class="pull-right"><strong><?php echo $test->patient_name; ?></strong></span> </a></td>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-clock-o"></i>Inprogress Tests</h4>
      </div>
      <div class="box-body">
        <table class="table">
          <?php foreach($inprogress_tests as $test){ 
	  
	 
	 //get the test groups for the pacient...
	 $query="SELECT
				`test_groups`.`test_group_name`
			FROM
			`invoice_test_groups`,
			`test_groups` 
			WHERE `invoice_test_groups`.`test_group_id` = `test_groups`.`test_group_id`
			AND `invoice_test_groups`.`invoice_id` = '".$test->invoice_id."'";
	$query_result = $this->db->query($query);
	$patient_tests = $query_result->result();
	$patienttests='';
	foreach($patient_tests as $patient_test){
		$patienttests.= $patient_test->test_group_name.', ';
		}	
			
	 
	  ?>
          <tr>
            <td  ><a href="#" onclick="get_patient_test_form('<?php echo $test->invoice_id; ?>')" > In#: <?php echo $test->invoice_id; ?> <span class="pull-right"><strong><?php echo $test->patient_name; ?></strong></span> </a></td>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-plus"></i>Add Test Detail</h4>
      </div>
      <div class="box-body" id="patient_test"> </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-check"></i>Completed Tests</h4>
      </div>
      <div class="box-body"> 
      
      <table class="table">
          <?php foreach($completed_tests as $test){ 
	  
	 
	 //get the test groups for the pacient...
	 $query="SELECT
				`test_groups`.`test_group_name`
			FROM
			`invoice_test_groups`,
			`test_groups` 
			WHERE `invoice_test_groups`.`test_group_id` = `test_groups`.`test_group_id`
			AND `invoice_test_groups`.`invoice_id` = '".$test->invoice_id."'";
	$query_result = $this->db->query($query);
	$patient_tests = $query_result->result();
	$patienttests='';
	foreach($patient_tests as $patient_test){
		$patienttests.= $patient_test->test_group_name.', ';
		}	
			
	 
	  ?>
          <tr>
            <td  ><a href="#" onclick="get_patient_test_form('<?php echo $test->invoice_id; ?>')" > In#: <?php echo $test->invoice_id; ?> <span class="pull-right"><strong><?php echo $test->patient_name; ?></strong></span> </a></td>
          </tr>
          <?php } ?>
        </table>
      
      </div>
    </div>
  </div>
</div>
<div id="information_model" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#information_model').modal('hide');">&times;</button>
        <h4 class="modal-title" id="information_model_title">Modal Header</h4>
      </div>
      <div class="modal-body" id="information_model_body" style="text-align:center !important">
        <div></div>
        <h3  id="invoice_id"></h3>
        <h4 id="patient_name"></h4>
        <div id="other_info" style="margin-bottom:10px; border:1px dashed #666666; border-radius:5px; "></div>
        <form action="<?php echo site_url(ADMIN_DIR.'lab/save_and_process') ?>" method="post">
          <input type="hidden" value="" name="invoice_id" id="invoiceid" />
          <input type="hidden" value="" name="patient_group_test_ids" id="patientgrouptestids" />
          <input required="required" placeholder="Enter test token ID" type="text" name="test_token_id" value="" />
          <input type="submit" value="Save and Process" name="save_and_process" />
        </form>
      </div>
      <div class="modal-footer" style="display: none">
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </div>
  </div>
</div>



<div id="test_form" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:90%"> 
    <!-- Modal content-->
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#test_form').modal('hide');">&times;</button>
        <h4 class="modal-title" id="information_model_title">Modal Header</h4>
      </div>
      <div class="modal-body" id="test_form_body"  style="text-align:center !important">
       
      </div>
      <div class="modal-footer" style="display: none">
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </div>
  </div>
</div>




<script>

function test_token(invoice_id, Patient_name, other_info){
      // $('#information_model_body').html('<div style="padding: 32px; text-align: center;"><img  src="<?php echo site_url('assets/admin/preloader.gif'); ?>" /></div>');
	  //alert(invoice_id);
       $('#information_model_title').html('Assign Test Token ID');
	   $('#invoice_id').html("Invoice No: "+invoice_id);
	   $('#patient_name').html("Patient Name: "+Patient_name);
	   $('#other_info').html($('#in_'+invoice_id).val());
	    $('#patientgrouptestids').val($('#patient_group_test_ids_'+invoice_id).val());
	   $('#invoiceid').val(invoice_id);
	   
       $('#information_model').modal('show');
	   
	   
	   
	  
       /*if(id){ id=id; }else{ id=0; }
       $.ajax({
         type: "POST",
         url: site_url + "/"+controller+"/"+con_function+"/",
         data: {id:id}
       }).done(function(data) {
         //console.log(data);
         $('#information_model_body').html(data);
       });*/
     }
	 
	 function get_patient_test_form(invoice_id){
		 
		 $.ajax({
         type: "POST",
         url: "<?php echo site_url(ADMIN_DIR); ?>/lab/get_patient_test_form/",
         data: {invoice_id:invoice_id}
       }).done(function(data) {
         //console.log(data);
         $('#test_form_body').html(data);
		  $('#test_form').modal('show');
		 
		 
       });
		 }
	 
</script>
<?php $this->load->view(ADMIN_DIR."reception/reception_footer"); ?>
