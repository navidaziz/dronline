<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title><?php echo $system_global_settings[0]->system_title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "js/magic-suggest/magicsuggest-1.3.1-min.css"); ?>" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/cloud-admin.css"); ?>" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/themes/default.css"); ?>" id="skin-switcher" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/responsive.css"); ?>" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/jquery-ui.css"); ?>" />
  <script>
    var site_url = '<?php echo base_url(ADMIN_DIR); ?>';
  </script>
  <!--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>-->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery/jquery-2.0.3.min.js"); ?>"></script>
  <script src="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/js/bootstrap.min.js"); ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/custom.css"); ?>" media="screen,print" />

  <!-- jstree resources -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR . "jstree-dist/jstree.min.js"); ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "jstree-dist/themes/default/style.min.css"); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR . "css/print.css"); ?>" media="print" />

</head>

<body>
  <div class="printDiv">
    <div id="print_area"></div>

  </div>
  <style>
    .printDiv {
      display: none;
    }

    @media print {

      .printDiv {
        display: block;
      }
    }
  </style>
  <div class="modal" id="edit_order" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="order_view_title"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Edit Order</h4>
        </div>
        <div class="modal-body" id="order_edit_form"> </div>
        <!-- <div class="modal-footer"> <a href="#" data-dismiss="modal" class="btn btn-primary">Close</a></div>-->
      </div>
    </div>
  </div>


  <header class="navbar clearfix" id="header">
    <div class="container">
      <div class="navbar-brand">
        <?php
        $wide_page[] = "dr_dashboard";
        $file = pathinfo($system_global_settings[0]->sytem_admin_logo);
        $log = $file['dirname'] . '/' . $file['filename'] . '_thumb.' . $file['extension'];
        ?>
        <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"> <img src="<?php echo site_url("assets/uploads/" . $log); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" class="img-responsive " style="width:40px !important; height:40px !important;"></a>
        <div class="visible-xs "> <a href="#" class="team-status-toggle switcher btn dropdown-toggle"> <i class="fa fa-users"></i> </a> </div>
        <div id="sidebar-collapse" class="sidebar-collapse btn"> <i class="fa fa-bars" data-icon1="fa fa-bars" data-icon2="fa fa-bars"></i> </div>
      </div>
      <div class="nav navbar-nav pull-left"> </div>
      <ul class="nav navbar-nav pull-right">
        <li style="float:right;" class="dropdown user" id="header-user"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img alt="" src="<?php
                                                                                                                                                      if ($this->session->userdata("user_image")) {

                                                                                                                                                        $file = pathinfo($this->session->userdata("user_image"));
                                                                                                                                                      } else {
                                                                                                                                                        $file['dirname'] = "";
                                                                                                                                                        $file['filename'] = "";
                                                                                                                                                        $file['extension'] = "";
                                                                                                                                                      }
                                                                                                                                                      echo site_url("assets/uploads/" . @$file['dirname'] . '/' . @$file['filename'] . '_thumb.' . @$file['extension']); ?>" /> <span class="username"><?php echo $this->session->userdata("user_title"); ?></span> <i class="fa fa-angle-down"></i> </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url(ADMIN_DIR . "users/update_profile"); ?>"><i class="fa fa-user"></i> Update Profile</a></li>
            <li><a href="<?php echo site_url(ADMIN_DIR . "users/logout"); ?>"><i class="fa fa-power-off"></i> Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </header>
  <section id="page">
    <?php


    $this->load->view(ADMIN_DIR . "components/nav.php");

    ?>
    <div id="main-content" <?php if (in_array($this->router->fetch_class(), $wide_page)) { ?> class="margin-left-50" <?php } ?>>
      <div class="container">
        <div class="row">
          <div id="content" class="col-lg-12">

            <?php if ($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")) {

              $type = "";
              if ($this->session->flashdata("msg_success")) {
                $type = "success";
                $msg = $this->session->flashdata("msg_success");
              } elseif ($this->session->flashdata("msg_error")) {
                $type = "error";
                $msg = $this->session->flashdata("msg_error");
              } else {
                $type = "info";
                $msg = $this->session->flashdata("msg");
              }
            ?>


              <div id="toast" style="height:auto !important;">
                <div id="desc"><?php echo $msg; ?></div>
              </div>

              <script>
                launch_toast();

                function launch_toast() {
                  var x = document.getElementById("toast")
                  x.className = "show";
                  setTimeout(function() {
                    x.className = x.className.replace("show", "");
                  }, 5000);
                }
              </script>
            <?php }  ?>