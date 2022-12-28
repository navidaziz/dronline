<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="row">
        <div class="col-md-6">
          <div class="clearfix">
            <h3 class="content-title pull-left"><?php echo $title; ?></h3>
          </div>
          <div class="description"><?php echo $title; ?></div>
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
        echo form_open_multipart(ADMIN_DIR . "users/update_profile/$user->user_id", $edit_form_attr);
        ?>
        <?php echo form_hidden("user_id", $user->user_id); ?>

        <div class="form-group">

          <?php
          $label = array(
            "class" => "col-md-2 control-label",
            "style" => "",
          );
          echo form_label($this->lang->line('user_title'), "user_title", $label);      ?>

          <div class="col-md-10">
            <?php

            $text = array(
              "type"          =>  "text",
              "name"          =>  "user_title",
              "id"            =>  "user_title",
              "class"         =>  "form-control",
              "style"         =>  "", "required"    => "required", "title"         =>  $this->lang->line('user_title'),
              "value"         =>  set_value("user_title", $user->user_title),
              "placeholder"   =>  $this->lang->line('user_title')
            );
            echo  form_input($text);
            ?>
            <?php echo form_error("user_title", "<p class=\"text-danger\">", "</p>"); ?>
          </div>



        </div>

        <div class="form-group">
          <?php
          $label = array(
            "class" => "col-md-2 control-label",
            "style" => "",
          );
          echo form_label($this->lang->line('user_email'), "user_email", $label);
          ?>
          <div class="col-md-10">
            <?php

            $text = array(
              "type"          =>  "text",
              "name"          =>  "user_email",
              "id"            =>  "user_email",
              "class"         =>  "form-control",
              "style"         =>  "",
              "title"         =>  $this->lang->line('user_email'),
              "value"         =>  set_value("user_email", $user->user_email),
              "placeholder"   =>  $this->lang->line('user_email')
            );
            echo  form_input($text);
            ?>
            <?php echo form_error("user_email", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>

        <div class="form-group">
          <?php
          $label = array(
            "class" => "col-md-2 control-label",
            "style" => "",
          );
          echo form_label($this->lang->line('user_password'), "user_password", $label);
          ?>
          <div class="col-md-10">
            <?php

            $text = array(
              "type"          =>  "text",
              "name"          =>  "user_password",
              "id"            =>  "user_password",
              "class"         =>  "form-control",
              "style"         =>  "",
              "title"         =>  $this->lang->line('user_password'),
              "value"         =>  set_value("user_password", $user->user_password),
              "placeholder"   =>  $this->lang->line('user_password')
            );
            echo  form_input($text);
            ?>
            <?php echo form_error("user_password", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
          $label = array(
            "class" => "col-md-2 control-label",
            "style" => "",
          );
          echo form_label($this->lang->line('user_mobile_number'), "user_mobile_number", $label);
          ?>
          <div class="col-md-10">
            <?php

            $text = array(
              "type"          =>  "text",
              "name"          =>  "user_mobile_number",
              "id"            =>  "user_mobile_number",
              "class"         =>  "form-control",
              "style"         =>  "",
              "title"         =>  $this->lang->line('user_mobile_number'),
              "value"         =>  set_value("user_mobile_number", $user->user_mobile_number),
              "placeholder"   =>  $this->lang->line('user_mobile_number')
            );
            echo  form_input($text);
            ?>
            <?php echo form_error("user_mobile_number", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
          $label = array(
            "class" => "col-md-2 control-label",
            "style" => "",
          );
          echo form_label($this->lang->line('user_image'), "user_image", $label);
          ?>
          <div class="col-md-10">
            <?php

            $file = array(
              "type"          =>  "file",
              "name"          =>  "user_image",
              "id"            =>  "user_image",
              "class"         =>  "form-control",
              "style"         =>  "",
              "title"         =>  $this->lang->line('user_image'),
              "value"         =>  set_value("user_image", $user->user_image),
              "placeholder"   =>  $this->lang->line('user_image')
            );
            echo  form_input($file);
            ?>
            <div class="col-md-3"> <?php echo file_type(base_url("assets/uploads/$user->user_image", false, false, "100%")); ?> </div>
            <?php echo form_error("user_image", "<p class=\"text-danger\">", "</p>"); ?>
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