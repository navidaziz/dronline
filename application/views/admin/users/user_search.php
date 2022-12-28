<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        
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
        `
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
      <div class="box-body text-center" style="min-height:200px">
      <form name="search" action="<?php echo site_url(ADMIN_DIR."profile_info/search") ?>" method="post" />
      Enter User Name / Mobile Number: <br /> <input placeholder="03002424545" type="text" name="user_name" value="" id="user_name" />
      <input type="submit" value="Search" />
     </form>
     <p>
     
     <?php if(@$users){ ?>
     
     
     <h3> Name: <?php echo $users[0]->user_title ?>  </h3>
      <h4> User Email:<strong> <?php echo $users[0]->user_email ?></strong>  </h4>
       <h4> Account User Name: <strong><?php echo $users[0]->user_name ?></strong>  </h4>
        <h4> Account Password: <strong><?php echo $users[0]->user_password ?> </strong> </h4>     <?php } ?>
        
        <?php if(@$message){ ?> 
		<em style="color:red"><?php echo $message; ?></em>
		<?php } ?>
     
     <?php if($user_password_code){ ?>
     <h1>Last PIN Code / Password:<?php echo $user_password_code; ?></h1>
     <?php } ?>
     </p>
     
     
      </div>
             </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
