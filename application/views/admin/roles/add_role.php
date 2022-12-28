<?php

//create icons
$module_list = "";
foreach($modules as $module){
    
    //if this module is a controller, set it as option group
    if($module->parent_id == 0){
        $module_list .= "<optgroup label='".$module->module_title."'>";
        
        //now lets get all actions of this controller
        foreach($modules as $cmodule){
            if($cmodule->parent_id == $module->module_id){
                $module_list .= "<option value='".$cmodule->module_id."'> ".$cmodule->module_title."</option>";
            }
        }
        $module_list .= "</optgroup>";
    }
    
}



?>
<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>">Home</a> </li>
        <li> 
          <!--<i class="fa fa-home"></i>--> 
          <a href="<?php echo site_url(ADMIN_DIR."roles/view"); ?>">Roles</a> </li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class='row'>
        <div class='col-md-6'>
          <div class='clearfix'>
            <h3 class='content-title pull-left'><?php echo $title; ?></h3>
          </div>
          <div class='description'><?php echo $title; ?></div>
        </div>
        <div class='col-md-6'>
          <div class='pull-right'> <a class='btn btn-primary btn-sm' href='<?php echo site_url(ADMIN_DIR."roles/add_role"); ?>'><i class='fa fa-plus'></i> New</a> <a class='btn btn-danger btn-sm' href='<?php echo site_url(ADMIN_DIR."roles/trashed_roles"); ?>'><i class='fa fa-trash-o'></i> Trash</a> </div>
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
        <h4><i class="fa fa-bell"></i><?php echo $title; ?></h4>
        <div class="tools"> <a href="#box-config" data-toggle="modal" class="config"> <i class="fa fa-cog"></i> </a> <a href="javascript:;" class="reload"> <i class="fa fa-refresh"></i> </a> <a href="javascript:;" class="collapse"> <i class="fa fa-chevron-up"></i> </a> <a href="javascript:;" class="remove"> <i class="fa fa-times"></i> </a> </div>
      </div>
      <div class="box-body"> <?php echo validation_errors(); ?>
        <form class="form-horizontal" role="form" id="role_form" method="post" action="<?php echo site_url(ADMIN_DIR."roles/add_role"); ?>">
          <div class="form-group">
            <label for="role_title" class="col-sm-2 control-label">Role Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="role_title" name="role_title" placeholder="Role Title" />
            </div>
          </div>
          <div class="form-group">
            <label for="role_desc" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="role_desc" name="role_desc" placeholder="Role Description" />
            </div>
          </div>
          <div class="form-group">
            <label for="role_level" class="col-sm-2 control-label">Role Level</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="role_level" name="role_level" placeholder="Role Level" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Role Homepage</label>
            <div class="col-sm-10">
              <select class="form-control" name="role_homepage">
                <?php echo $module_list; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Role Status </label>
            <div class="col-md-10">
              <label class="radio">
                <input type="radio" class="uniform" name="status" value="1" checked="checked" />
                Active </label>
              <label class="radio">
                <input type="radio" class="uniform" name="status" value="0" />
                Inactive </label>
            </div>
          </div>
          <div class="form-group">
            <input type="hidden" value="" id="checked_modules" name="checked_modules" />
            <label class="col-md-2 control-label">Assign Modules </label>
            <div class="col-md-10" id="roles_tree">
              <ul>
                <?php
                        foreach($module_tree as $cont_id => $cont_t){
                           echo "<li id=".$cont_id.">";
                           foreach($cont_t as $cont_title => $action){
                                echo $cont_title;
                                //start of actions ul
                                echo "<ul>";
                                foreach($action as $act_id => $act_att){
                                    echo "<li id='".$act_id."'";
                                    echo " >".$act_att[1]."</li>";
                                }
                                //enc of action ul
                                echo "</ul>";
                                //end of controller li
                                echo "</li>";
                           }
                        }
                      
                      ?>
              </ul>
            </div>
          </div>
          <script>
                    $(document).ready(function() {
                        jQuery("#roles_tree").jstree({
                            "plugins" : [ "themes", "html_data", "checkbox", "ui" ]
                        });
                        $("#role_form").submit(function(){
                            var ids = $("#roles_tree").jstree().get_checked(false);
                            console.log(ids);
                            $("#checked_modules").val(ids);
                            /*alert(ids);
                            return false;*/
                        })
                    });
                </script>
          
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/js/select2/select2.min.js"></script> 
<script>
		
		$('#project').select2({
			placeholder: "Select Projects"
			});
</script>