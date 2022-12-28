 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 <div id="edit_test" class="modal" tabindex="-1" role="dialog">
     <div class="modal-dialog" role="document">
         <div class="modal-content">

             <div id="edit_test_body">



             </div>

         </div>
     </div>
 </div>

 <script>
     function edit_test(test_id) {
         $.ajax({
             type: "POST",
             url: '<?php echo site_url(ADMIN_DIR . "test_groups/edit_test_form"); ?>',
             data: {
                 test_id: test_id,
                 test_group_id: <?php echo $test_groups[0]->test_group_id ?>
             }
         }).done(function(data) {
             $('#edit_test_body').html(data);
             $('#edit_test').modal('show');
         });

     }
 </script>

 <div class="row">
     <div class="col-sm-12">
         <div class="page-header">
             <!-- STYLER -->

             <!-- /STYLER -->
             <!-- BREADCRUMBS -->
             <ul class="breadcrumb">
                 <li>
                     <i class="fa fa-home"></i>
                     <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                 </li>
                 <li>
                     <i class="fa fa-table"></i>
                     <a href="<?php echo site_url(ADMIN_DIR . "test_groups/view/"); ?>">Services List</a>
                 </li>
                 <li><?php echo $test_groups[0]->test_group_name; ?> List</li>
             </ul>
             <!-- /BREADCRUMBS -->
             <div class="row">

                 <div class="col-md-6">
                     <div class="clearfix">
                         <h3 class="content-title pull-left"><?php echo $test_groups[0]->test_group_name; ?></h3>
                     </div>
                     <div class="description">
                         Time <?php echo $test_groups[0]->test_time; ?> - Price <?php echo $test_groups[0]->test_price; ?> Rs
                     </div>
                 </div>


             </div>


         </div>
     </div>
 </div>
 <!-- /PAGE HEADER -->

 <!-- PAGE MAIN CONTENT -->
 <div class="row">


     <div class="col-md-8">
         <div class="box border blue" id="messenger">
             <div class="box-title">
                 <h4><i class="fa fa-flask" aria-hidden="true"></i><?php echo $test_groups[0]->test_group_name; ?> List</h4>

             </div>
             <div class="box-body">

                 <div class="table-responsive">
                     <?php
                        $add_form_attr = array("class" => "form-horizontal");
                        echo form_open_multipart(ADMIN_DIR . "test_groups/save_test_group_data/" . $test_groups[0]->test_group_id, $add_form_attr);
                        ?>
                     <table class="table">
                         <tr>
                             <td style="width: 150px;">
                                 Add New Test in <?php echo $test_groups[0]->test_group_name; ?> List
                             </td>
                             <td>

                                 <select place name="test_id[]" class="js-example-basic-single" multiple="multiple" required="required" style="width: 100% !important;">
                                     <?php foreach ($test_types as $test_type) { ?>

                                         <optgroup label="<?php echo $test_type->test_type;  ?>">
                                             <?php foreach ($test_type->tests as $test_id => $test_name) { ?>
                                                 <option value="<?php echo $test_id; ?>"><?php echo $test_name; ?></option>
                                             <?php } ?>
                                         </optgroup>
                                     <?php } ?>
                                 </select>
                                 <?php echo form_error("test_id", "<p class=\"text-danger\">", "</p>"); ?>
                             </td>
                             <td style="width: 150px;"><input class="btn btn-success" type="submit" value="Add Test" name="Add Test" /></td>
                         </tr>
                     </table>
                     <?php echo form_close(); ?>
                     <hr />
                     <?php foreach ($test_group_types as $test_group_type) { ?>
                         <?php if ($test_group_type->test_type != 'NULL') { ?>
                             <h5><?php echo $test_group_type->test_type; ?></h5>
                         <?php } ?>
                         <table class="table table-b ordered" style="width: 100%;">
                             <thead>

                                 <tr>
                                     <th>#</th>
                                     <th>Test(s)</th>
                                     <th> Result Suffix</th>
                                     <th>Unit</th>
                                     <th style="width: 300px;">Normal Value(s)</th>
                                     <!-- <th>Test Nature</th> -->
                                     <th><?php echo $this->lang->line('Order'); ?></th>
                                     <th><?php echo $this->lang->line('Action'); ?></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    $count = 1;
                                    foreach ($test_group_type->test_group_tests as $test_group_test) : ?>

                                     <tr>
                                         <td><?php echo $count++; ?></td>
                                         <td> <?php echo $test_group_test->test_name; ?> </td>
                                         <td><?php echo $test_group_test->result_suffix; ?></td>
                                         <td>
                                             <?php echo $test_group_test->unit; ?>
                                         </td>
                                         <td> <?php echo $test_group_test->normal_values; ?> </td>
                                         <!-- <td><?php
                                                    if ($test_group_test->test_type == 'NULL') {
                                                    } else {
                                                        echo $test_group_test->test_type;
                                                    } ?></td> -->
                                         <td>

                                             <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR . "test_groups/up_test/" . $test_group_test->test_group_test_id . "/" . $test_groups[0]->test_group_id); ?>"><i class="fa fa-arrow-up"></i> </a>
                                             <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR . "test_groups/down_test/" . $test_group_test->test_group_test_id . "/" . $test_groups[0]->test_group_id); ?>"><i class="fa fa-arrow-down"></i></a>
                                         </td>
                                         <td>
                                             <a onclick="return confirm('Are you sure?')" class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR . "test_groups/delete_test/" . $test_group_test->test_group_test_id . "/" . $test_groups[0]->test_group_id); ?>"><i class="fa fa-trash-o"></i></a>
                                             <span style="margin-left: 10px;"></span>
                                             <a class="llink llink-trash" href="javascript:edit_test(<?php echo $test_group_test->test_id; ?>);"> <i class="fa fa-pencil-square-o"></i></a>


                                         </td>
                                     </tr>
                                 <?php endforeach; ?>
                             </tbody>
                         </table>

                     <?php } ?>

                 </div>


             </div>

         </div>
     </div>



     <div class="col-md-4">
         <div class="box border blue" id="add_test_form" style="dis play: none;">
             <div class="box-title">
                 <h4><i class="fa fa-plus"></i> Add New Test</h4>
             </div>
             <div class="box-body">
                 <?php
                    $add_form_attr = array("class" => "form-horizontal");
                    echo form_open_multipart(ADMIN_DIR . "test_groups/save_test_data/" . $test_groups[0]->test_group_id, $add_form_attr);
                    ?>
                 <table class="table">
                     <input type="hidden" name="test_category_id" value="<?php echo $test_groups[0]->category_id; ?>" />
                     <tr>
                         <th>Test Nature</th>
                         <th><?php echo form_dropdown("test_type_id", $test_types_list, "", "class=\"form-control\" required=\"required\" style=\"\""); ?></th>
                     </tr>
                     <tr>
                         <th>Test</th>
                         <th><input type="text" name="test_name" value="" id="test_name" class="form-control" style="" required="required" title="Test Name" placeholder="Test Name"></th>
                     </tr>
                     <tr>
                         <th>Result Suffix</th>
                         <th><input type="text" name="result_suffix" value="" id="result_suffix" class="form-control" style="" title="Result Suffix" placeholder="Result Suffix"></th>
                     </tr>
                     <tr>
                         <th>Unit</th>
                         <td><input type="text" value="" name="test_unit" id="test_unit" class="form-control" /></td>
                     </tr>
                     <tr>
                         <th colspan="2">
                             <?php echo $this->lang->line('normal_values') ?>
                             <textarea name="normal_values" value="" id="normal_values" class="form-control" style="width: 100%;" rows="7" title="Normal Values" placeholder="Normal Values"></textarea>
                         </th>
                     </tr>
                     <tr>
                         <th>Add Test</th>
                         <th><input type="submit" name="submit" value="Save" class="b tn bt n-primary" style=""></th>
                     </tr>
                 </table>
                 <?php echo form_close(); ?>






             </div>
         </div>
     </div>


     <!-- /MESSENGER -->
 </div>

 <script>
     function add_test_unit(test_id) {
         test_unit = $('#test_unit_' + test_id).val();
         $.ajax({
             type: "POST",
             url: '<?php echo site_url(ADMIN_DIR . "test_groups/add_test_unit"); ?>',
             data: {
                 test_unit: test_unit,
                 test_id,
                 test_id
             }
         }).done(function(data) {
             //$('#edit_student_info_body').html(data);
         });
     }
 </script>



 <script>
     // In your Javascript (external .js resource or <script> tag)
     $(document).ready(function() {
         $('.js-example-basic-single').select2();
     });
 </script>