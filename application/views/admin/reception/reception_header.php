<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title><?php echo $system_global_settings[0]->system_title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."js/magic-suggest/magicsuggest-1.3.1-min.css"); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."css/cloud-admin.css"); ?>" />
  <link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/".ADMIN_DIR."css/themes/default.css"); ?>" id="skin-switcher" />
  <link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/".ADMIN_DIR."css/responsive.css"); ?>" />
  <script> var site_url='<?php echo base_url(ADMIN_DIR); ?>';</script>
  <!--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>-->
  <script src="<?php echo site_url("assets/".ADMIN_DIR."js/jquery/jquery-2.0.3.min.js"); ?>"></script>
  <script  src="<?php echo site_url("assets/".ADMIN_DIR."bootstrap-dist/js/bootstrap.min.js"); ?>"></script>
  <!-- jstree resources -->
  <script src="<?php echo site_url("assets/".ADMIN_DIR."jstree-dist/jstree.min.js"); ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR."jstree-dist/themes/default/style.min.css"); ?>" />
  <link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/".ADMIN_DIR."css/custom.css"); ?>" />
  <!-- Select2- Css -->
  <link rel="stylesheet" href="<?= base_url( "assets/".ADMIN_DIR."plugins/select2/select2.min.css" ); ?>">
  <!-- SLIDENAV -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/slidernav/slidernav.css" />


  <!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->

  

</head>
<body >


<section id="page" >
<?php $this->load->view(ADMIN_DIR."components/nav.php"); ?>
<div id="main-content"  class="margin-left-50"  >
<div class="container">
<div class="row">
<div id="content" class="col-lg-12" style="padding: 0px !important; margin:0px !important;">
  
  <section id="page" >
    <?php if($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")){
              
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
              <div id="toast"><div id="img"><i style="color:yellow" class="fa fa-exclamation-circle" aria-hidden="true"></i></div><div id="desc"><?php echo $msg; ?></div></div>
              <script>
                $(function(){
                  //alert();
                  launch_toast();

                })
              
              function launch_toast() {
              var x = document.getElementById("toast")
              x.className = "show";
              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
              }
              </script>
              <?php }  ?>
              
    <div class="container" style="padding-top:5px">
      
