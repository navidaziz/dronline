 <!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Update Your Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."/css/cloud-admin.css"); ?>" >

</head>
<body class="login" style="position: relative;
    height: 100%;
    background-image: url(<?php echo site_url("assets/".ADMIN_DIR."/images/background.jpeg"); ?>);
    background-size: cover;
    ">
<!-- PAGE -->
<section id="page"> 
  <!-- HEADER -->
  <header> 
    
    <!-- NAV-BAR -->
    <div class="container" >
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div id="logo">
            </div>
        </div>
      </div>
    </div>
    <!--/NAV-BAR --> 
  </header>
  <!--/HEADER --> 
  <!-- LOGIN -->
  <section id="login" class="visible" >
    <div class="container">
      <div class="row">
       <div class="col-md-5">
       <div style="margin-top:100px; text-align:center !important">
       <img src="<?php echo site_url("assets/uploads/".$system_global_settings[0]->sytem_admin_logo); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" style="width:250px !important" />
        <h2 class="bigintro" style="color:black !important; text-shadow:#999;"><?php echo $system_global_settings[0]->system_title ?></h2>
        <h4 style="color:black" ><?php echo $system_global_settings[0]->system_sub_title ?></h4>
        
       </div>
        
       </div>
        <div class="col-md-7">
          <div class="login-box-plain"  style="opacity: 0.9 !important">
            <h2 style="text-align:center !important;">Welcome <?php echo $user->user_title ?></h2>
            <h4 style="text-align:center !important; color:#D2322D;">Complete your profile</h1>
            <h6 style="text-align:center; color:#093;" >Please Update your profile and password.</h6>
            
            <div class="box-body">
        <?php
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."complete_profile/update_profile_complete/", $edit_form_attr);
            ?>
        
        
        
        
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('user_mobile_number'), "user_mobile_number", $label);
                ?>
          <div class="col-md-8">
            <?php
                    
                    $text = array(
                        "type"          =>  "number",
                        "name"          =>  "user_mobile_number",
                        "id"            =>  "user_mobile_number",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('user_mobile_number'),
                        "value"         =>  set_value("user_mobile_number", $user->user_mobile_number),
                        "placeholder"   =>  $this->lang->line('user_mobile_number'),
						"required" => "required"
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("user_mobile_number", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        
        <div class="form-group">
        <p  style="text-align:center; color: #b94a48; margin-left:137px;">
        <span style="background:#FCF; padding:5px;">Note: Your password must be at least 7 characters long.</span>
        </p>
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                   echo form_label("Account New Password", "user_new_password", $label);
                ?>
          <div class="col-md-8">
            <?php
                    
                    $text = array(
                        "type"          =>  "password",
                        "name"          =>  "user_new_password",
                        "id"            =>  "user_new_password",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  "Enter New Password ",
                        "value"         =>  "",
                        "placeholder"   =>  "Enter New Password ",
						//"required" => "required"
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("user_new_password", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                   echo form_label("Confirm New Password", "confirm_new_password", $label);
                ?>
          <div class="col-md-8">
            <?php
                    
                    $text = array(
                        "type"          =>  "password",
                        "name"          =>  "confirm_new_password",
                        "id"            =>  "confirm_new_password",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  "Confirm New Password ",
                        "value"         =>  "",
                        "placeholder"   =>  "Confirm New Password ",
						//"required" => "required"
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("confirm_new_password", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        
        <div class="col-md-offset-4 col-md-4" >
          <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Update'),
                    "class" =>  "btn btn-success",
                    "style" =>  "background-color:#396"
                );
                echo form_submit($submit); 
            ?>
          
        </div>
        <div style="clear:both;"></div>
        <?php echo form_close(); ?> </div>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>
  </section>
</section>
<link href="<?php echo site_url("assets/".ADMIN_DIR."/font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet">
</body>
</html>