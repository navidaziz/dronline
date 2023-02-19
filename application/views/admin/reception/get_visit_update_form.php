<div class="modal-header">
    <button type="button" class="close" onclick="$('#information_model').modal('hide');">&times;</button>
    <h4 class="modal-title" id="model_header">Update Patient History</h4>
</div>
<form onsubmit="return confirm('Do you really want to submit the form?');" action="<?php echo site_url(ADMIN_DIR . "reception/update_visit"); ?>" method="post">
    <div class="modal-body">
        <input type="hidden" value="<?php echo $visit_id; ?>" name="visit_id" />
        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>" />
        <input type="hidden" name="history_id" value="<?php echo $history_id; ?>" />
        <?php
        $query = "SELECT * FROM `patient_visits` WHERE 
        visit_id = '" . $visit_id . "'
        AND `patient_id` = '" . $patient_id . "' 
        AND history_id = '" . $history_id . "'";
        $visit = $this->db->query($query)->row();
        ?>

        <h4>Update Remarks</h4>
        <textarea style="width: 100%;" rows="5" name="dr_prescriptions"><?php echo $visit->remarks; ?></textarea>

    </div>
    <div class="modal-footer" style="text-align: center;">
        <button type="submit" class="btn btn-success">Update Visit Remarks</button>
    </div>
</form>