Search By Receipt No: <input type="text" name="search_receipt_no" id="search_receipt_no" />
<script>
    $('#search_receipt_no').on('keydown', function(e) {
        if (e.keyCode == 13) {
            var receipt_no = $('#search_receipt_no').val();
            // $('#item_list').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(ADMIN_DIR . "sale_point/search_by_receipt_no") ?>",
                data: {
                    receipt_no: receipt_no
                }
            }).done(function(data) {
                $('#customer_recipt').html(data);
            });
        }

    });

    function return_sale_item(sale_item_id){
        if (event.key === 'Enter') {
            var total_items_returns = $('#return_item_'+sale_item_id).val();
            var sale_item_id = sale_item_id;
            // $('#item_list').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(ADMIN_DIR . "sale_point/return_sale_item") ?>",
                data: {
                    sale_item_id: sale_item_id,
                    total_items_returns: total_items_returns
                }
            }).done(function(data) {
                $('#customer_recipt').html(data);
            });
        }
    }
</script>

<div class="row">
    <div class="col-sm-6">
        <div id="customer_recipt"></div>
        Print Receipt
    </div>

    <div class="col-sm-6">
        Return Items
    </div>
</div>