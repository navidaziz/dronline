<div class="modal-header">
    <button type="button" class="close" onclick="$('#information_model').modal('hide');">&times;</button>
    <h4 class="modal-title" id="model_header">Update Patient History</h4>
</div>
<form action="<?php echo site_url(ADMIN_DIR . "reception/update_mark_detail"); ?>" method="post">
    <div class="modal-body">
        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>" />
        <input type="hidden" name="invoice_id" value="<?php echo $history_id; ?>" />
        <?php
        $query = "SELECT * FROM `invoices` WHERE `patient_id` = '" . $patient_id . "' and invoice_id = '" . $history_id . "'";
        $history = $this->db->query($query)->row();
        ?>
        <h4>Update Remarks</h4>
        <textarea style="width: 100%;" rows="5" name="remarks"><?php echo $history->remarks; ?></textarea>

    </div>
    <div class="modal-footer" style="text-align: center;">
        <button type="submit" class="btn btn-success">Update Remarks</button>
    </div>
</form>