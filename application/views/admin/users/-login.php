<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."/css/cloud-admin.css"); ?>" >

</head>
<body class="login">
<!-- PAGE -->
<section id="page" style=" 
    position: relative;
    height: 100%;
    background-image: url(<?php echo site_url("assets/".ADMIN_DIR."/images/darewro_background.jpg"); ?>);
    background-size: cover;
    overflow: auto;
    font-family: "Open Sans", Helvetica, Arial, sans-serif;"> 
  <!-- HEADER -->
  <header> 
    
    <!-- NAV-BAR -->
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div id="logo">
            <?php
                                    if($this->session->flashdata('msg')){
                                        
                                        echo '<div class="alert alert-block alert-danger fade in">
    											<a class="close" data-dismiss="alert" href="#" aria-hidden="true"><i class="fa fa-times"></i></a>
    											<h4><i class="fa fa-times"></i> Oh snap! You got an error!</h4>
    												<p>'.$this->session->flashdata('msg').'</p>
    										</div>';
                                    }
                                ?>
            <?php echo validation_errors(); ?> </div>
        </div>
      </div>
    </div>
    <!--/NAV-BAR --> 
  </header>
  <!--/HEADER --> 
  <!-- LOGIN -->
  <section id="login" class="visible">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div class="login-box-plain" >
            <h2 class="bigintro"><?php echo $system_global_settings[0]->system_title ?></h2>
            <p style="font-size:20px !important; text-align:center !important; color:#D2322D;">Login In</p>
            <!--<img src="<?php echo site_url("assets/uploads/".$system_global_settings[0]->sytem_admin_logo); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" weight="100" height="80">-->
            <div class="divide-40"></div>
            <form role="form" method="post" action="<?php echo site_url(ADMIN_DIR."users/login"); ?>">
              <div class="form-group">
                <label for="user_email">User Name</label>
                <i class="fa fa-envelope"></i>
                <input type="text" class="form-control" id="user_email" name="user_email" value="<?php echo set_value("user_email"); ?>" />
              </div>
              <div class="form-group">
                <label for="user_password">Password</label>
                <i class="fa fa-lock"></i>
                <input type="password" class="form-control" id="user_password" name="user_password" />
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn-danger">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</section>
<link href="<?php echo site_url("assets/".ADMIN_DIR."/font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet">
</body>
</html>