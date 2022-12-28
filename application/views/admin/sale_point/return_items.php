<?php $this->load->view(ADMIN_DIR . "sale_point/recepit");  ?>
<div style="margin: 5px; text-align: center;">
    <a target="new" href="<?php echo site_url(ADMIN_DIR . "sale_point/print_receipt/" . $sale->sale_id) ?>">Print Receipt</a>
</div>