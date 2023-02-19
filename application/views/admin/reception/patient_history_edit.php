<div class="modal-header">
    <button type="button" class="close" onclick="$('#information_model').modal('hide');">&times;</button>
    <h4 class="modal-title" id="model_header">Update Patient History</h4>
</div>
<form action="<?php echo site_url(ADMIN_DIR . "reception/update_patient_test_detail"); ?>" method="post">
    <div class="modal-body">
        <input type="hidden" name="patient_test_id" value="<?php echo $id; ?>" />
        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>" />
        <input type="hidden" name="invoice_id" value="<?php echo $history_id; ?>" />
        <?php
        $query = "SELECT * FROM `patient_tests` WHERE `patient_test_id` = '" . $id . "'";
        $patient_test = $this->db->query($query)->row();
        ?>
        <h4><?php echo ucwords($patient_test->test_name); ?></h4>
        <textarea style="width: 100%;" rows="5" name="test_result"><?php echo $patient_test->test_result; ?></textarea>

    </div>
    <div class="modal-footer" style="text-align: center;">
        <button type="submit" class="btn btn-success">Update <?php echo ucwords($patient_test->test_name); ?></button>
    </div>
</form>