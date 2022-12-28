<div class="modal-header">
    <h5 class="modal-title ">
        Edit Test Detail

        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </h5>

</div>
<div class="modal-body">
    <form action="<?php echo site_url(ADMIN_DIR . "test_groups/update_test_data/$test_group_id"); ?>" method="post">
        <table class="table">
            <input type="hidden" name="test_category_id" value="<?php echo $test->test_category_id ?>" />
            <input type="hidden" name="test_id" value="<?php echo $test->test_id ?>">

            <tbody>
                <tr>
                    <th>Test Type</th>
                    <th>
                        <?php
                        echo form_dropdown("test_type_id", $test_types, $test->test_type_id, "class=\"form-control\" required style=\"\"");
                        ?>
                    </th>
                </tr>
                <tr>
                    <th>Test Name</th>
                    <th><input type="text" name="test_name" value="<?php echo $test->test_name; ?>" id="test_name" class="form-control" style="" required="required" title="Test Name" placeholder="Test Name"></th>
                </tr>
                <tr>
                    <th>Result Suffix</th>
                    <th><input type="text" name="result_suffix" value="<?php echo $test->result_suffix; ?>" id="result_suffix" class="form-control" style="" title="Result Suffix" placeholder="Result Suffix"></th>
                </tr>
                <tr>
                    <th>Unit</th>
                    <td><input type="text" value="<?php echo $test->unit; ?>" name="test_unit" id="test_unit" class="form-control"></td>
                </tr>
                <tr>
                    <th colspan="2">
                        Normal Values <textarea name="normal_values" value="" id="normal_values" class="form-control" style="width: 100%;" rows="7" title="Normal Values" placeholder="Normal Values"><?php echo $test->normal_values; ?></textarea>
                    </th>
                </tr>
                <tr>
                    <th>Update Test</th>
                    <th><input type="submit" name="submit" value="Update" class="b tn bt n-primary" style=""></th>
                </tr>
            </tbody>
        </table>





</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>