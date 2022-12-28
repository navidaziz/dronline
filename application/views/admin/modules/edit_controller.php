<?php

//create icons
$icon_list = "";
$allicons = "";
foreach ($icons as $icon) {
	$icon_list .= "<option value='" . $icon->icon_title . "'";
	if ($icon->icon_title == $controller->module_icon) {
		$icon_list .= " selected='selected' ";
	}
	$icon_list .= ">" . $icon->icon_title . "</option>";
	$allicons .= "<div class='col-md-1'><i class='fa " . $icon->icon_title . "'></i><br />" . $icon->icon_title . "</div>";
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
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url($this->session->userdata(ADMIN_DIR . "role_homepage_uri")); ?>">Home</a>
				</li>
				<li>
					<!--<i class="fa fa-home"></i>-->
					<a href="<?php echo site_url(ADMIN_DIR . "modules/controllers"); ?>">Controllers</a>
				</li>
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
					<div class='pull-right'>
						<a class='btn btn-primary btn-sm' href='<?php echo site_url(ADMIN_DIR . "modules/add_controller"); ?>'><i class='fa fa-plus'></i> New</a>
						<a class='btn btn-danger btn-sm' href='<?php echo site_url(ADMIN_DIR . "modules/trashed_controllers"); ?>'><i class='fa fa-trash-o'></i> Trash</a>
					</div>
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
				<div class="tools">
					<a href="#box-config" data-toggle="modal" class="config">
						<i class="fa fa-cog"></i>
					</a>
					<a href="javascript:;" class="reload">
						<i class="fa fa-refresh"></i>
					</a>
					<a href="javascript:;" class="collapse">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a href="javascript:;" class="remove">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>
			<div class="box-body">

				<?php echo validation_errors(); ?>

				<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(ADMIN_DIR . "modules/edit_controller/" . $controller->module_id); ?>">

					<div class="form-group">
						<label for="module_title" class="col-sm-2 control-label">Controller Title</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="module_title" name="module_title" placeholder="Controller Title" value="<?php echo set_value('module_title', $controller->module_title); ?>" />
						</div>
					</div>


					<div class="form-group">
						<label for="module_desc" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="module_desc" name="module_desc" placeholder="Controller Description" value="<?php echo set_value('module_desc', $controller->module_desc); ?>" />
						</div>
					</div>


					<div class="form-group">
						<label for="module_title" class="col-sm-2 control-label">Controller URI</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="module_uri" name="module_uri" placeholder="Controller URI" value="<?php echo set_value('module_uri', $controller->module_uri); ?>" />
						</div>
					</div>




					<div class="form-group">
						<label class="col-md-2 control-label">Menu Status </label>
						<div class="col-md-10">
							<label class="radio"> <input type="radio" class="uniform" name="module_menu_status" value="1" <?php echo radio_checked($controller->module_menu_status, "1"); ?> /> Show in menu </label>
							<label class="radio"> <input type="radio" class="uniform" name="module_menu_status" value="0" <?php echo radio_checked($controller->module_menu_status, "0"); ?> /> Don't show in menu </label>
						</div>
					</div>



					<div class="form-group">
						<label class="col-sm-2 control-label">Controller Icon
							<i class="<?php echo $controller->module_icon ?>"></i>

						</label>
						<div class="col-sm-10">
							<input type="text" value="<?php echo $controller->module_icon ?>" name="module_icon" class="form-control" />
							<!--<select class="form-control" name="module_icon">
				  <?php echo $icon_list; ?>
				</select>-->

						</div>
					</div>




					<div class="form-group">
						<label class="col-md-2 control-label">Status </label>
						<div class="col-md-10">
							<label class="radio"> <input type="radio" class="uniform" name="status" value="1" <?php echo radio_checked($controller->status, "1"); ?> /> Active </label>
							<label class="radio"> <input type="radio" class="uniform" name="status" value="0" <?php echo radio_checked($controller->status, "0"); ?> /> Inactive </label>
						</div>
					</div>






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
<div class="row">
	<?php echo $allicons; ?>
</div>