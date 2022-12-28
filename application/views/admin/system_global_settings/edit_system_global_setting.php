<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<!-- STYLER -->
			
			<!-- /STYLER -->
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
				</li><li>
				<i class="fa fa-table"></i>
				<a href="<?php echo site_url(ADMIN_DIR."system_global_settings/view/"); ?>"><?php echo $this->lang->line('System Global Settings'); ?></a>
			</li><li><?php echo $title; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
            <div class="row">
                        
                <div class="col-md-6">
                    <div class="clearfix">
					  <h3 class="content-title pull-left"><?php echo $title; ?></h3>
					</div>
					<div class="description"><?php echo $title; ?></div>
                </div>
                
                <div class="col-md-6">
                    <!--<div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."system_global_settings/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."system_global_settings/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>-->
                </div>
                
            </div>
            
			
		</div>
	</div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
		<!-- MESSENGER -->
	<div class="col-md-12">
	<div class="box border blue" id="messenger">
		<div class="box-title">
			<h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
		</div>
        <div class="box-body">

            <?php
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."system_global_settings/update_data/$system_global_setting->system_global_setting_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("system_global_setting_id", $system_global_setting->system_global_setting_id); ?>
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('system_title'), "system_title", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "system_title",
                        "id"            =>  "system_title",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('system_title'),
                        "value"         =>  set_value("system_title", $system_global_setting->system_title),
                        "placeholder"   =>  $this->lang->line('system_title')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("system_title", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('system_sub_title'), "system_sub_title", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "system_sub_title",
                        "id"            =>  "system_sub_title",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('system_sub_title'),
                        "value"         =>  set_value("system_sub_title", $system_global_setting->system_sub_title),
                        "placeholder"   =>  $this->lang->line('system_sub_title')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("system_sub_title", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );  echo form_label($this->lang->line('sytem_public_logo')."<br />".file_type(base_url("assets/uploads/".$system_global_setting->sytem_public_logo)), "sytem_public_logo", $label);     ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "sytem_public_logo",
                        "id"            =>  "sytem_public_logo",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('sytem_public_logo'),
                        "value"         =>  set_value("sytem_public_logo", $system_global_setting->sytem_public_logo),
                        "placeholder"   =>  $this->lang->line('sytem_public_logo')
                    );
                    echo  form_input($file);
                ?>
                    <!--<?php echo file_type(base_url("assets/uploads/$system_global_setting->sytem_public_logo")); ?>-->
                    
                <?php echo form_error("sytem_public_logo", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );  echo form_label($this->lang->line('sytem_admin_logo')."<br />".file_type(base_url("assets/uploads/".$system_global_setting->sytem_admin_logo)), "sytem_admin_logo", $label);     ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "sytem_admin_logo",
                        "id"            =>  "sytem_admin_logo",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('sytem_admin_logo'),
                        "value"         =>  set_value("sytem_admin_logo", $system_global_setting->sytem_admin_logo),
                        "placeholder"   =>  $this->lang->line('sytem_admin_logo')
                    );
                    echo  form_input($file);
                ?>
                    <!--<?php echo file_type(base_url("assets/uploads/$system_global_setting->sytem_admin_logo")); ?>-->
                    
                <?php echo form_error("sytem_admin_logo", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('phone_number'), "phone_number", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "phone_number",
                        "id"            =>  "phone_number",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('phone_number'),
                        "value"         =>  set_value("phone_number", $system_global_setting->phone_number),
                        "placeholder"   =>  $this->lang->line('phone_number')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("phone_number", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('mobile_number'), "mobile_number", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "mobile_number",
                        "id"            =>  "mobile_number",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('mobile_number'),
                        "value"         =>  set_value("mobile_number", $system_global_setting->mobile_number),
                        "placeholder"   =>  $this->lang->line('mobile_number')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("mobile_number", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('fax_number'), "fax_number", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "fax_number",
                        "id"            =>  "fax_number",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('fax_number'),
                        "value"         =>  set_value("fax_number", $system_global_setting->fax_number),
                        "placeholder"   =>  $this->lang->line('fax_number')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("fax_number", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('email_address'), "email_address", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "email_address",
                        "id"            =>  "email_address",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('email_address'),
                        "value"         =>  set_value("email_address", $system_global_setting->email_address),
                        "placeholder"   =>  $this->lang->line('email_address')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("email_address", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('address'), "address", $label);
                ?>

                <div class="col-md-10">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "address",
                        "id"            =>  "address",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('address'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("address", $system_global_setting->address),
                        "placeholder"   =>  $this->lang->line('address')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("address", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('web_address'), "web_address", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "web_address",
                        "id"            =>  "web_address",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('web_address'),
                        "value"         =>  set_value("web_address", $system_global_setting->web_address),
                        "placeholder"   =>  $this->lang->line('web_address')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("web_address", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('description'), "description", $label);
                ?>

                <div class="col-md-10">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "description",
                        "id"            =>  "description",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('description'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("description", $system_global_setting->description),
                        "placeholder"   =>  $this->lang->line('description')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("description", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="col-md-offset-2 col-md-10">
            <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Update'),
                    "class" =>  "btn btn-primary",
                    "style" =>  ""
                );
                echo form_submit($submit); 
            ?>
            
            
            
            <?php
                $reset = array(
                    "type"  =>  "reset",
                    "name"  =>  "reset",
                    "value" =>  $this->lang->line('Reset'),
                    "class" =>  "btn btn-default",
                    "style" =>  ""
                );
                echo form_reset($reset); 
            ?>
            </div>
            <div style="clear:both;"></div>
            
            <?php echo form_close(); ?>
            
        </div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
