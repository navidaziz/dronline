<?php $this->load->view(ADMIN_DIR."reception/reception_header"); ?>

 <?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."reception/save_data", $add_form_attr);
            ?>
<div class="row"> 
  <!-- MESSENGER -->
  <div class="col-md-3">







    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-user"></i>Patient Detail</h4>
      </div>
      <div class="box-body">

      <table style="width: 100%;">
<tr><td style="text-align: center; color: #BC181D;"><?php  $file = pathinfo($system_global_settings[0]->sytem_admin_logo);
        $log = $file['dirname'].'/'.$file['filename'].'_thumb.'.$file['extension'];
        ?>
        <!-- <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"> 
        <img src="<?php echo site_url("assets/uploads/".$log); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" 
        title="<?php echo $system_global_settings[0]->system_title ?>" class="img-responsive " style="width:40px !important;"></a>-->
        <h4 style="margin-top: -5px;"><strong> CHITRAL CITY</strong></h4>  
        <h5  style="margin-top: -5px;">Medical Laboratory</h5>      
        </td> 
<td><ul class="nav navbar-nav pull-right" style="margin-top: -20px;" >
        <li style="float:right"  class="dropdown user" id="header-user"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img alt="" 
          src="<?php
          $file = pathinfo($this->session->userdata("user_image"));
          
          
          echo site_url("assets/uploads/".@$file['dirname'].'/'.@$file['filename'].'_thumb.'.@$file['extension']); ?>" /> <span class="username"><?php echo $this->session->userdata("user_title"); ?></span> <i class="fa fa-angle-down"></i> </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url(ADMIN_DIR."users/update_profile"); ?>"><i class="fa fa-user"></i> Update Profile</a></li>
            <li><a href="<?php echo site_url(ADMIN_DIR."users/logout"); ?>"><i class="fa fa-power-off"></i> Log Out</a></li>
          </ul>
        </li>
        
        
        
       
      </ul></td></tr>
</table>
<hr style="margin-top: -5px;" />
<table style="width: 100%;">
<tr><td>Patient Name: </td><td><input type="text" name="patient_name" value="" id="patient_name" class="for m-control" style="" required="required" title="Name" placeholder="Name"></td></tr>
<tr><td>Mobile No: </td><td><input type="text" name="patient_mobile_no" value="" id="patient_mobile_no" class="for m-control" style="" required="required" title="Mobile No" placeholder="Mobile No"></td></tr>
<tr><td>Address: </td><td><input type="text" name="patient_address" value="" id="patient_address" class="for m-control" style="" required="required" title="Address" placeholder="Address"></td></tr>
<tr><td>Age: </td><td><input type="number" name="patient_age" value="" id="patient_age" class="for m-control" style="" required="required" title="Patient Age" placeholder="Patient Age"></td></tr>
<tr><td>Sex: </td><td><input type="radio" name="patient_gender" value="Male" id="patient_gender" style="" required="required" class="uniform"><label for="patient_gender" style="margin-left:10px;">Male</label><input type="radio" name="patient_gender" value="Female" id="patient_gender" style="" required="required" class="uniform"><label for="patient_gender" style="margin-left:10px;">Female</label></td></tr>
<tr><td>Refered By: </td><td><select class="for m-control" required name="refered_by">
     <option value="">Refered By</option>
	  <?php 
			
			$query="SELECT * FROM `doctors` WHERE `status`=1";
			$query_result = $this->db->query($query);
			$doctors = $query_result->result();
			
                        foreach($doctors as $doctor){ ?>
                        <option value="<?php echo $doctor->doctor_id; ?>"><?php echo $doctor->doctor_name; ?></option>
                        <?php }  ?>
            <?php echo form_error("refered_by", "<p class=\"text-danger\">", "</p>"); ?>
            
            </select></td></tr>

</table>
       <hr />
       
            
          
        
        <div>



        
        
       <div id="test_price_list" style="min-height: 180px;">
        <table class="table table-bordered">
        <tr><td>#</td><td>Test Name</td><td>Price</td></tr>
        
        </table>
        </div>
        <style>
        
        table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
          padding: 5px !important;
        }
        </style>

<hr/>
<div style="margin-bottom:10px; border:1px dashed #666666; border-radius:5px;  padding:5px; margin-bottom:5px">
        <table style="width:100%">
        <tr>
        <td rowspan="3"><strong>Discount:<strong> <br />
        <input onkeyup="update_price_list()" type="number" name="discount" value="0" id="discount" class="for m-control" style="width:80px" /></td>
        <th>Total Price:</th><td id="test_total_price">00.00 Rs. </td></tr>
        <tr><th>Discount: </th><td id="discount_total">00.00 Rs.</td></tr>
        <tr><th>Payable: </th><th id="payable">00.00 Rs.</th></tr>
        </table>
</div>
        <input type="submit" name="submit" value="Save and Print" class="btn btn-primary" style="width:100%">
        </div>
        
        
        </div>
    </div>
  </div>
  <div class="col-md-5" style="padding-left:1px !important; padding-right:1px !important; ">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-flask"></i>Lab Tests</h4>
      </div>
      <div class="box-body">
      <div class="row" style="font-size: 12px !important;">
      
      
        <?php foreach($test_groups as $test_group){ ?>
        <div class="col-md-3" style="padding-left:8px !important; padding-right:8px !important; ">
		<div style="margin:1px; border:1px solid #CCC; border-radius:2px; margin-bottom:5px; -webkit-box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);
-moz-box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);
box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);  ">
		<input style="display: inline;" name="test_group_id[]" id="TG_<?php echo $test_group->test_group_id; ?>" onclick="set_price('<?php echo $test_group->test_group_id; ?>', '<?php echo $test_group->test_group_name; ?>', '<?php echo $test_group->test_price; ?>', '<?php echo $test_group->test_time; ?>')" type="checkbox" value="<?php echo $test_group->test_group_id; ?>" />
    <strong style="margin-left:2px;"><?php echo substr($test_group->test_group_name,0,20); ?></strong>
        <span style="font-size:9px; display:block; margin-left:30px !important"> Rs: <?php echo $test_group->test_price; ?> - 
        <?php echo $test_group->test_time; ?>min</span>
        </div>
        </div>
        
        <?php } ?>
        
        </div>
        
        
        
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-file"></i>lab Test Report Status</h4>
      </div>
      <div class="box-body" style="font-size: 12px !important;"> 
      
      <table class="table table-bordered">
      <thead>
							<tr >
								<th>#</th>
								<th>Name</th>
								<th>Mobile</th>
								<th>Status</th>
															</tr>
						</thead>
          <?php foreach($all_tests as $test){ 
            $color = '';
            if($test->status==1){ $color = "#E9F1FC"; }
            if($test->status==2){ $color = "#FF9999"; }
            if($test->status==3){ $color = "#F0FFF0"; }

            ?>
          <tr style="background-color: <?php echo $color; ?>;" >
            <td><?php echo $test->invoice_id; ?> </td>
            <td><?php echo $test->patient_name; ?></td>
            <td><?php echo $test->patient_mobile_no; ?></td>
            <td>
            <?php  if($test->status==1){ 
              
              $other_info = 'Patient Name: '.$test->patient_name.'<br />';
              $other_info.= 'Mobile No: '.$test->patient_mobile_no.'<br />';
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
            
              <input id="in_<?php echo $test->invoice_id; ?>" type="hidden" value="<?php echo $other_info; ?>" />
              <input id="patient_group_test_ids_<?php echo $test->invoice_id; ?>" type="hidden" value="<?php echo $patient_group_test_ids; ?>" />
            <a href="#" onclick="test_token('<?php echo $test->invoice_id; ?>')">New</a> <?php  } ?>
            <?php  if($test->status==2){ ?> <a href="#" onclick="get_patient_test_form('<?php echo $test->invoice_id; ?>')">Add Result</a> <?php  } ?>
            <?php  if($test->status==3){ ?> 
              <a href="#" onclick="get_patient_test_report('<?php echo $test->invoice_id; ?>')">View Report</a>
              <a style="margin-left: 10px;" target="new"  href="<?php echo site_url(ADMIN_DIR."lab/print_patient_test_report/$test->invoice_id") ?>"  ><i class="fa fa-print" aria-hidden="true"></i> Print</a>

             <?php  } ?>
           </td>
          </tr>
          <?php } ?>
        </table>
      
      </div>
    </div>
  </div>
</div>


<?php echo form_close(); ?>


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
        <form action="<?php echo site_url(ADMIN_DIR.'reception/save_and_process') ?>" method="post">
          <input type="hidden" value="" name="invoice_id" id="invoiceid" />
          <input type="hidden" value="" name="patient_group_test_ids" id="patientgrouptestids" />
          <input required="required" placeholder="Enter test token ID" type="hidden" name="test_token_id" value="<?php echo time(); ?>" />
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
        <h4 class="modal-title" id="test_form_title">Test Report</h4>
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
	   
     }
	 
	 function get_patient_test_form(invoice_id){
		 
		 $.ajax({
         type: "POST",
         url: "<?php echo site_url(ADMIN_DIR); ?>/lab/get_patient_test_form/",
         data: {invoice_id:invoice_id}
       }).done(function(data) { 
         $('#test_form_body').html(data);
		     $('#test_form').modal('show'); 
        });
		 }

     function get_patient_test_report(invoice_id){
		 
		 $.ajax({
         type: "POST",
         url: "<?php echo site_url(ADMIN_DIR); ?>/lab/get_patient_test_report/",
         data: {invoice_id:invoice_id}
       }).done(function(data) { 
         $('#test_form_body').html(data);
		     $('#test_form').modal('show'); 
        });
		 }
     

     prices  = [];
     var test_total_price = 0;
     function set_price(test_group_id, test_group_name, test_price, test_time){

      if($('#TG_'+test_group_id).is(':checked')){
        test_total_price = 0;
        prices[test_group_name] = {'price' : test_price, 'test_time' : test_time };
      }else{
        test_total_price = 0;
        delete prices[test_group_name];
      }
     // prices.forEach(element => console.log(element));
      var price_list = '<table class="table table-bordered"><tr><td>#</td><td>Test Name</td><td>Price</td></tr>';
     
      var count=0;
      for (var key in prices) {
        
        if (prices.hasOwnProperty(key))
            count = parseInt(count)+1;
            price_list+='<tr><td>'+count+'</td>';
            price_list+='<td>'+key+'</td>';
            price_list+='<td>'+prices[key].price+'</td>';
            price_list+='</td></tr>';
            test_total_price = parseInt(test_total_price)+parseInt(prices[key].price);



      }
      price_list+= '</table>';

      $('#test_price_list').html(price_list);
      $('#test_total_price').html(test_total_price+'.00 Rs.');
      var discount = $('#discount').val();
      
      $('#discount_total').html(discount+'.00 Rs.');
      var payable = parseInt(test_total_price)-discount;
      $('#payable').html(payable+'.00 Rs.');
      
      //prices.forEach(test_price_list_function);
      // for (i = 0; i < prices.length; i++) {
      //     console.log(numbers[i]);
      //   } 
              
      
     }

     function update_price_list(){
      $('#test_total_price').html(test_total_price+'.00 Rs.');
      var discount = $('#discount').val();
      
      $('#discount_total').html(discount+'.00 Rs.');
      var payable = parseInt(test_total_price)-discount;
      $('#payable').html(payable+'.00 Rs.');
     }

     function test_price_list_function(test_group_name, values){
       alert();
      //$('#test_price_list').html(price_list);
      console.log(test_group_name);
     }
	 
</script>


<?php $this->load->view(ADMIN_DIR."reception/reception_footer"); ?>
