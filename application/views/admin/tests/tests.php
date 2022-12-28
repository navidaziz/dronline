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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."tests/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."tests/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
			<!--<div class="tools">
            
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
				

			</div>-->
		</div><div class="box-body">
			
            <div class="table-responsive">
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
 
                
                    <table class="table table-bordered" id="testTable">
						<thead>
						  <tr>
                          
							<th><?php echo $this->lang->line('test_name'); ?></th>
<!-- <th><?php echo $this->lang->line('test_time'); ?></th>
<th><?php echo $this->lang->line('test_price'); ?></th> -->
<!-- <th><?php echo $this->lang->line('test_description'); ?></th> -->
<th>Unit</th>
<th><?php echo $this->lang->line('normal_values'); ?></th>
<th><?php echo $this->lang->line('test_category'); ?></th>
<th><?php echo $this->lang->line('test_type'); ?></th><th><?php echo $this->lang->line('Order'); ?></th><th><?php echo $this->lang->line('Status'); ?></th><th><?php echo $this->lang->line('Action'); ?></th>
                        </tr>
						</thead>
						<tbody>
					  <?php foreach($tests as $test): ?>
                         
                         <tr>
                         
                             
            <td>
                <?php echo $test->test_name; ?>
            </td>
            <!-- <td>
                <?php echo $test->test_time; ?>
            </td>
            <td>
                <?php echo $test->test_price; ?>
            </td> -->
            <!-- <td>
                <?php echo substr($test->test_description, 0,  20); ?>
            </td> -->
            <td>  
                <input onkeyup="add_test_unit('<?php echo $test->test_id; ?>')" type="text" value="<?php echo $test->unit; ?>" name="test_unit" id="test_unit_<?php echo $test->test_id; ?>" />
                         </td>

            <td>
                <?php echo $test->normal_values; ?>
            </td>
            <td>
                <?php echo $test->test_category; ?>
            </td>
            <td>
                <?php echo $test->test_type; ?>
            </td>
                                <td>
                                  <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR."tests/up/".$test->test_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-arrow-up"></i> </a>
                                  <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR."tests/down/".$test->test_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-arrow-down"></i></a>
                                </td>
                                <td>
                                    <?php echo status($test->status,  $this->lang); ?>
                                    <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($test->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."tests/publish/".$test->test_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($test->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."tests/draft/".$test->test_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?>
                                </td>
                                <td>
                                <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."tests/view_test/".$test->test_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."tests/edit/".$test->test_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."tests/trash/".$test->test_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
                            </td>
                         </tr>
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

<script>
function add_test_unit(test_id){
test_unit = $('#test_unit_'+test_id).val();
$.ajax({
				type: "POST",
				url: '<?php echo site_url(ADMIN_DIR . "test_groups/add_test_unit"); ?>',
				data: {
					test_unit: test_unit,
                    test_id, test_id
				}
			}).done(function(data) {
				//$('#edit_student_info_body').html(data);
			});
}
</script>

<script>

$(document).ready( function () {
    $('#testTable').DataTable({
      "pageLength": 500
    });
} );

</script>