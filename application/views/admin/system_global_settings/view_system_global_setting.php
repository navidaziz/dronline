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
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."system_global_settings/edit/1"); ?>"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('Edit'); ?></a>
                        
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
			<h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
		</div><div class="box-body">
			
            <div class="table-responsive">
                
                    <table class="table">
						<thead>
						  
						</thead>
						<tbody>
					  <?php foreach($system_global_settings as $system_global_setting): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('system_title'); ?></th>
                <td>
                    <?php echo $system_global_setting->system_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('system_sub_title'); ?></th>
                <td>
                    <?php echo $system_global_setting->system_sub_title; ?>
                </td>
            </tr>
            <tr>
                <th>Sytem Public Logo</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$system_global_setting->sytem_public_logo));
                ?>
                </td>
            </tr>
            <tr>
                <th>Sytem Admin Logo</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$system_global_setting->sytem_admin_logo));
                ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('phone_number'); ?></th>
                <td>
                    <?php echo $system_global_setting->phone_number; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('mobile_number'); ?></th>
                <td>
                    <?php echo $system_global_setting->mobile_number; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('fax_number'); ?></th>
                <td>
                    <?php echo $system_global_setting->fax_number; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('email_address'); ?></th>
                <td>
                    <?php echo $system_global_setting->email_address; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('address'); ?></th>
                <td>
                    <?php echo $system_global_setting->address; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('web_address'); ?></th>
                <td>
                    <?php echo $system_global_setting->web_address; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('description'); ?></th>
                <td>
                    <?php echo $system_global_setting->description; ?>
                </td>
            </tr>
                         
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      
                      

            </div>
			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
