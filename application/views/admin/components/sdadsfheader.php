<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title><?php echo $system_global_settings[0]->system_title ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">


<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."css/cloud-admin.css"); ?>" />
<link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/".ADMIN_DIR."css/themes/default.css"); ?>" id="skin-switcher" />
<link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/".ADMIN_DIR."css/responsive.css"); ?>" />

<!-- STYLESHEETS --><!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->

<link href="<?php echo site_url("assets/".ADMIN_DIR."font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet" />

<!-- ANIMATE -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."css/animatecss/animate.min.css"); ?>" />

<!-- date picker-->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."js/bootstrap-datepicker/css/bootstrap-datepicker.css"); ?>" />

<!-- JQUERY -->
<script src="<?php echo site_url("assets/".ADMIN_DIR."js/jquery/jquery-2.0.3.min.js"); ?>"></script>

<!-- BOOTSTRAP -->
<script src="<?php echo site_url("assets/".ADMIN_DIR."bootstrap-dist/js/bootstrap.min.js"); ?>"></script>

<!-- GRITTER -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."js/gritter/css/jquery.gritter.css"); ?>" />
<!-- FONTS -->
<link href='<?php echo site_url("assets/".ADMIN_DIR."css/fonts.css"); ?>' rel='stylesheet' type='text/css' />

<!-- jstree resources -->
<script src="<?php echo site_url("assets/".ADMIN_DIR."jstree-dist/jstree.min.js"); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."jstree-dist/themes/default/style.min.css"); ?>" />

<!-- HUBSPOT MESSENGER -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."js/hubspot-messenger/css/messenger.min.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."js/hubspot-messenger/css/messenger-theme-flat.min.css"); ?>" />
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR."js/hubspot-messenger/js/messenger.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR."js/hubspot-messenger/js/messenger-theme-flat.js"); ?>"></script>
<!-- HUBSPOT MESSENGER -->
<!-- SELECT2 -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/select2/select2.min.css" />
<!-- TYPEAHEAD -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/typeahead/typeahead.css" />
<!-- SELECT2 -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/select2/select2.min.css" />
<!-- UNIFORM -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/uniform/css/uniform.default.min.css" />

<!-- DATE PICKER -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/datepicker/themes/default.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/datepicker/themes/default.date.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/datepicker/themes/default.time.min.css" />


<!-- custome styhles -->

<!--<script src="<?php echo site_url("assets/".ADMIN_DIR."js/script.js"); ?>"></script>-->
<?php if($this->lang->line('direction')=="rtl"){ ?>
<style>
.sidebar-menu > ul > li > ul.sub > li > a {
	color: #555555;
	font-size: 13px;
	font-weight: 400;
	margin-right: 15px !important;
	padding-right: 5px !important;
}


</style>
<?php } ?>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
 <script src="<?php echo site_url("assets/".ADMIN_DIR); ?>/tinymce/js/tinymce/tinymce.min.js"></script>

<script>
var stakeholder_or_activity ="";
function get_list(from, where_get, change_field_id){
	//alert(from);
		id=$('#'+where_get+'_f').val();
		
		//alert(where_get);
	
		
		
		if(where_get == 'stakeholder_type_id'){
			var stakeholder_or_activity = $('#'+where_get+'_f :selected').parent().attr('label');
			//alert(stakeholder_or_activity);
			if(stakeholder_or_activity == 'Activities'){
				$('.change_title').html('Activity ');
				$('.note_title').html('Activity ');
				$('#stakeholder_name_label').html('Short Activity Description');
				$('#approachtype').hide();
				$('#approachtype').html('<input type="radio" checked="checked" name="approach_type_id" value="3" />');
				$('#stakeholdercontactnumber').hide('<input name="stakeholder_contact_number" value="" />');
				
				
				
			}else{
				$('#stakeholder_name_label').html('Stakeholder Name');
				$('.change_title').html('Stakeholder ');
				$('.note_title').html('Meeting');
				<?php 
				$approach_option="";
				if(isset($approach_types)){
					foreach($approach_types as $approach_type_id => $approach_type){
						if($approach_type_id!=3){
					$approach_option.='<input type="radio" name="approach_type_id" value="'.$approach_type_id.'" id="approach_type_id" required="required" class="uniform"><label for="1" style="margin-left:10px; margin-right:15px;">'.$approach_type.'</label>';
						}
					?>
				
				
				<?php } ?>
				<?php } ?>
				var approach_type_div='<label class="control-label" style="display:block;">Stakeholder Approach Type<a href="javescript:void(0);"><i onclick="open_help_model(\'approach_type\')" style="color:red; font-size:14px;" class="fa fa-question-circle pull-right"> <span></span> </i></a></label><br><?php echo  $approach_option; ?>';
				
				
				$('#stakeholdercontactnumber').html('<label for="stakeholder_contact_number" class="control-label" id="stakeholder_contact_number_label" style="">Contact Information</label><input type="text" name="stakeholder_contact_number" value="" id="stakeholder_contact_number" class="form-control" style="" required="required" title="Contact Detail" placeholder="Phone # or Email">');
				$('#stakeholdercontactnumber').show();
				
				$('#approachtype').html(approach_type_div);
				$('#approachtype').show();
				}
		}
		
		url="<?php echo base_url()."".ADMIN_DIR; ?>";
		url=url+from;
		url=url+"/get_json/"+where_get+"/";
		url=url+id;
		console.log(url);
		$.ajax({ type: "POST",url: url,data:{ }}).done(function( data ) { 
				var obj = JSON.parse(data);
				var option="";
				for(var id in obj){
					option=option+"<option value='"+obj[id].id+"'>"+obj[id].value+"</option>";
				}
				$("#"+change_field_id+"_f").html(option);
			});
		// if project select the get project based forms fields...
		if(where_get == 'project_id'){
			id=$('#'+where_get+'_f').val();
			$.ajax({ type: "POST",url: "<?php echo base_url()."".ADMIN_DIR."project_extra_fields/get_extra_fields/"; ?>"+id,data:{ }}).done(function( data ) { 
				var obj = JSON.parse(data);
				var option='';
				
				for(var id in obj){
				
					
					if(obj[id].project_extra_field_type == 'text'){
						option=option+'<div class="form-group">';
							option=option+'<label for="'+obj[id].project_extra_field_name+'" class="col-md-2 control-label" style="">'+obj[id].project_extra_field_name+'</label><div class="col-md-10">';
						option=option+'<input type="text" name="project_extra_field['+obj[id].project_extra_field_id+']" value="" id="meeting_start_date" class="form-control" style="" required title="'+obj[id].project_extra_field_name+'" placeholder="'+obj[id].project_extra_field_name+'">';
						option=option+"</div></div>";
						}
					
//for radio button 
	if(obj[id].project_extra_field_type == 'radio'){
			option=option+'<div class="form-group">';
			option=option+'<label for="'+obj[id].project_extra_field_name+'" class="col-md-2 control-label" style="">'+obj[id].project_extra_field_name+'</label><div class="col-md-10">';
			if(obj[id].field_items.length){
				for(var id2 in obj[id].field_items){
				option=option+'<input type="radio" name="project_extra_field['+obj[id].project_extra_field_id+']" value="'+obj[id].field_items[id2].project_extra_field_value+'" id="meeting_start_date" class="uniform" style="" required > <label for="1" style="margin-left:10px;">'+obj[id].field_items[id2].project_extra_field_value+'</label> <br />';
				}
			 }
			option=option+"</div></div>";
		}

// end for radio button	

//for Dropdown button 
	if(obj[id].project_extra_field_type == 'dropdown'){
			option=option+'<div class="form-group">';
			option=option+'<label for="'+obj[id].project_extra_field_name+'" class="col-md-2 control-label" style="">'+obj[id].project_extra_field_name+'</label><div class="col-md-10">';
			if(obj[id].field_items.length){
				option=option+'<select name="project_extra_field['+obj[id].project_extra_field_id+']" class="form-control" required="" style="" id="'+obj[id].project_extra_field_id+'" >';
				for(var id2 in obj[id].field_items){
				option=option+'<option value="'+obj[id].field_items[id2].project_extra_field_value+'">'+obj[id].field_items[id2].project_extra_field_value+'</option>';
				}
				option=option+'</select>';
			 }
			option=option+"</div></div>";
		}

// end for dropdown button
				}
				
				$("#form_extra_fields").html(option);
			});
			
		}
		// end here
}
</script>

<!-- time line -->
		<link rel="stylesheet" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/horizontal_timeline/css/reset.css">
        <!-- CSS reset -->
        <link rel="stylesheet" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/horizontal_timeline/css/style.css">
        <!-- Resource style -->
        <script src="<?php echo site_url("assets/".ADMIN_DIR); ?>/horizontal_timeline/js/modernizr.js"></script><!-- Modernizr -->
	<!-- end time line -->
<!-- Bootstrap core CSS -->
<link href="<?php echo site_url("assets/".ADMIN_DIR); ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
<body>

<!-- HEADER -->
<style>
.navbar .navbar-brand img {
position: absolute;
max-width: 60%;
height: 80px;
width: 257px;
top: 5px;
left: 60px;
}
</style>

<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."css/my_fucki ng_style.css"); ?>" />
<header class="navbar clearfix" id="header">
  <div class="container">
    <div class="navbar-brand" style="height:100px;"> 
      
      <!-- COMPANY LOGO --> 
      <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"> <img src="<?php echo site_url("assets/uploads/".$system_global_settings[0]->sytem_admin_logo); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" class="img-responsive "  width="120"></a> 
      <!-- /COMPANY LOGO --> 
      <!-- TEAM STATUS FOR MOBILE -->
      <div class="visible-xs "> <a href="#" class="team-status-toggle switcher btn dropdown-toggle"> <i class="fa fa-users"></i> </a> </div>
      <!-- /TEAM STATUS FOR MOBILE --> 
      <!-- SIDEBAR COLLAPSE -->
      <div id="sidebar-collapse" class="sidebar-collapse btn"> <i class="fa fa-bars" 
							data-icon1="fa fa-bars" 
							data-icon2="fa fa-bars" ></i> </div>
      <!-- /SIDEBAR COLLAPSE --> 
    </div>
    <div class="nav navbar-nav pull-left"   > 
      <!--<h3 style="color:white;"><?php echo $row['site_name']; ?></h3>--> 
      <!--<h5 style="color:white;">Government Of Khyber Pakhtunkhwa</h5>--> 
    </div>
    
    <!-- BEGIN TOP NAVIGATION MENU -->
    <ul class="nav navbar-nav pull-right">
      <h3 style="color:white; float:right; display:block;"><?php //echo $system_global_settings[0]->system_title ?></h3>
      <br>
      
      <!-- BEGIN NOTIFICATION DROPDOWN --> 
       <?php if($this->session->userdata('role_id')==13){ ?>
     
      <li class="dropdown" id="header-notification"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell"></i> <span class="badge"><?php echo count($all_notifications); ?></span> </a>
        <ul class="dropdown-menu notification">
        
          <li class="dropdown-title"> <span><i class="fa fa-bell"></i> <?php echo count($all_notifications); ?> New Administrative Requests </span> </li>
          
          <?php 
		 
		  foreach($all_notifications as $notification){ ?>
          
           <li> <a href="<?php echo site_url(ADMIN_DIR."notifications/notification_view/$notification->add_notification_id"); ?>"> <span class="label label-warning"><i class="fa fa-exclamation-triangle"></i></span> <span class="body"> <span class="message"><?php echo $notification->group_name; ?></span> 
           <br>
<span><?php echo $notification->demand_sub_type_title; ?></span>
          <!-- <span class="time"> <i class="fa fa-clock-o"></i> <span>6 hrs</span> </span>--> </span> </a> </li>
           <?php } ?>
           
          <li class="footer"> <a href="<?php echo site_url(ADMIN_DIR."notifications/all_notifications"); ?>">See all notifications <i class="fa fa-arrow-circle-right"></i></a> </li>
        </ul>
      </li>
      
      <?php } ?> 
      <!--<li class="dropdown" id="header-message"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope"></i> <span class="badge">1</span> </a>
        <ul class="dropdown-menu inbox">
          <li class="dropdown-title"> <span><i class="fa fa-envelope-o"></i> 1 Messages</span> <span class="compose pull-right tip-right" title="Compose message"><i class="fa fa-pencil-square-o"></i></span> </li>
          
          
          <li> <a href="#"> <img src="<?php echo site_url("assets/uploads/".$this->session->userdata("user_image")); ?>" alt="" /> <span class="body"> <span class="from">Debby Doe</span> <span class="message"> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse mole ... </span> <span class="time"> <i class="fa fa-clock-o"></i> <span>2 hours ago</span> </span> </span> </a> </li>
          <li class="footer"> <a href="#">See all messages <i class="fa fa-arrow-circle-right"></i></a> </li>
        </ul>
      </li>-->
     
     
     
      <li style="float:right;" class="dropdown user" id="header-user"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img alt="" 
      src="<?php echo site_url("assets/uploads/".$this->session->userdata("user_image")); ?>" /> <span class="username"><?php echo $this->session->userdata("user_title"); ?></span> <i class="fa fa-angle-down"></i> </a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo site_url(ADMIN_DIR."users/update_profile"); ?>"><i class="fa fa-user"></i> Update Profile</a></li>
          <!--<li><a href="#"><i class="fa fa-cog"></i> Account Settings</a></li>
          <li><a href="#"><i class="fa fa-eye"></i> Privacy Settings</a></li>-->
          <li><a href="<?php echo site_url(ADMIN_DIR."users/logout"); ?>"><i class="fa fa-power-off"></i> Log Out</a></li>
          
        </ul>
       
      </li>
       <?php if($this->session->userdata('role_id')==14){ ?>
      <li style="float:left;">
      <a href="<?php echo site_url(ADMIN_DIR."sm_map/sm_map"); ?>" style="padding:0px;" >
      <img title="Community Groups Map" alt="" src="<?php echo base_url()."assets/admin/images/google_map.png"; ?>" width="45" /> 
      </a>
      </li>
      <?php }
	  if($this->session->userdata('role_id')==13)
	  { ?>
       <li style="float:left;">
      <a href="<?php echo site_url(ADMIN_DIR."dashboard/index"); ?>" style="padding:0px;" >
      <img title="Community Groups Map" alt="" src="<?php echo base_url()."assets/admin/images/google_map.png"; ?>" width="45" /> 
      </a>
      </li>
      <?php } ?>
      <?php if($this->session->userdata('role_id')==14){ ?>
      <!-----------Shifting groups kamran--------->
     <li style="float:right;" class="dropdown user" id="header-user"> 
     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
     <img alt="" src="<?php echo base_url()."assets/admin/images/shiftgroups.png"; ?>"  /> 
     
     <span class="username">Select Group</span> <i class="fa fa-angle-down"></i> </a>
        <ul class="dropdown-menu">
          
          <li>
          <?php
		  $current_group_name ="Name of the Group";
		  //var_dump($this->session->userdata['group_id']);
		  $groups_all_ids = explode("-",$this->session->userdata['groups_all_ids']);
		 	  
		  foreach($groups_all_ids as $gIds)
		  {
			    if($gIds > 0){
				$sel_g="SELECT
    `groups`.`group_name`
	,`groups`.`group_id`
    , `groups`.`group_code`
    , `group_gender_types`.`group_gender_type_title`
    , `group_types`.`group_type_title`
FROM
`group_gender_types`
,`groups` 
,`group_types`
WHERE `group_gender_types`.`group_gender_type_id` = `groups`.`group_gender_type_id`
AND `group_types`.`group_type_id` = `groups`.`group_type_id`
AND  `groups`.`group_id` = ".$gIds;	
				$sel_g_q = $this->db->query($sel_g);	
				$sel_g_type = $sel_g_q->result();
				//var_dump($sel_g_type);
				foreach($sel_g_type as $index => $grps){
					//var_dump($grps);
			  ?>
		
        
        	<a <?php if($grps->group_id == $this->session->userdata('group_id')){   ?>style="color:blue !important" <?php } ?> href="<?php echo site_url(ADMIN_DIR); ?>/users/shift_group/<?php echo $gIds; ?>" >
			<?php echo $grps->group_name; ?><span style="font-size:10px !important; margin-left:5px;">(<?php echo $grps->group_gender_type_title; ?>)</span>
            </a>			  
              
		   <?php
				} // if
		    }
		   }
		  ?>
          
          </li>
        </ul>
      </li>
      <?php } ?>
      <!-----------Shifting groups kamran--------->
      
      <!-- END USER LOGIN DROPDOWN -->
    </ul>
    <!-- END TOP NAVIGATION MENU --> 
  </div>
</header>
<!--/HEADER --> 

<!-- PAGE -->
<section id="page" >
<?php 
$this->load->view(ADMIN_DIR."components/nav.php"); ?>
<div id="main-content"  <?php if($this->router->fetch_class()=='dashboard' or $this->router->fetch_class()=='group_dashboard'  or $this->uri->segment(3)== 'view_meeting'){ ?> class="margin-left-50" <?php } ?>  >
<div class="container">
<div class="row">
<div id="content" class="col-lg-12">
<?php
                        if($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")){ 
                        
                        $type = "";
                        if($this->session->flashdata("msg_success")){
                            $type = "success";
                            $msg = $this->session->flashdata("msg_success");
                        }elseif($this->session->flashdata("msg_error")){
                            $type = "error";
                            $msg = $this->session->flashdata("msg_error");
                        }else{
                            $type = "info";
                            $msg = $this->session->flashdata("msg");
                        }
                    ?>
<script type="text/javascript">
                            $(document).ready(function(){
                                    //Set theme
                        			Messenger.options = {
  			                            extraClasses: 'messenger-fixed messenger-on-top messenger-on-right',
                        				theme: "flat"
                        			}
                                    Messenger().post({
                                        message: '<?php echo $msg; ?>',
                                        type: '<?php echo $type; ?>',
                                        showCloseButton: true
                                    })
                                })
                                
                       </script>
<?php } ?>
