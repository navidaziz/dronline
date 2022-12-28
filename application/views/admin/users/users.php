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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."users/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."users/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                
                    <table class="table table-bordered">
						<thead>
						  <tr>
                          
							<th><?php echo $this->lang->line('user_title'); ?></th>
<th><?php echo $this->lang->line('user_email'); ?></th>
<th><?php echo $this->lang->line('user_mobile_number'); ?></th>
<th><?php echo $this->lang->line('user_name'); ?></th>
<th><?php echo $this->lang->line('user_password'); ?></th>
<th><?php echo $this->lang->line('user_image'); ?></th>
<th><?php echo $this->lang->line('role_title'); ?></th><th><?php echo $this->lang->line('Status'); ?></th><th><?php echo $this->lang->line('Action'); ?></th>
                        </tr>
						</thead>
						<tbody>
					  <?php foreach($users as $user): ?>
                        <?php if($user->user_id!=1){ ?> 
                         <tr>
                         
                             
            <td>
                <?php echo $user->user_title; ?>
            </td>
            <td>
                <?php echo $user->user_email; ?>
            </td>
            <td>
                <?php echo $user->user_mobile_number; ?>
            </td>
            <td>
                <?php echo $user->user_name; ?>
            </td>
            <td>
                <?php echo $user->user_password; ?>
            </td>
            <td>
            <?php
                echo file_type(base_url("assets/uploads/".$user->user_image));
            ?>
            </td>
            <td>
                <?php echo $user->role_title; ?>
            </td>
                                <td>
                                    <?php echo status($user->status,  $this->lang); ?>
                                    <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($user->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."users/publish/".$user->user_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($user->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."users/draft/".$user->user_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?>
                                </td>
                                <td>
                                <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."users/view_user/".$user->user_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."users/edit/".$user->user_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."users/trash/".$user->user_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
                            </td>
                         </tr>
                         <?php } ?>
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      <?php echo $pagination; ?>
                      

            </div>
			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
