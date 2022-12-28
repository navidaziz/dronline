<script>
    $('#search_receipt_no').on('keydown', function(e) {
        if (e.keyCode == 13) {
            var receipt_no = $('#search_receipt_no').val();
            get_receipt_list(receipt_no);
        }

    });

    function get_receipt_list(search) {
        $('#receipt_list').html('<p style="text-align:center"><strong>Please Wait...... Loading</strong></p>');

        alert(search);
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(ADMIN_DIR . "sale_point/receipt_list") ?>",
            data: {
                search: search
            }
        }).done(function(data) {
            $('#receipt_list').html(data);
        });

    }

    function search_by_receipt_no(receipt_no) {
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
</script>

<div class="row">


    <div class="col-sm-8">
        <div style="padding: 5px; margin-bottom: 5px; border: 1px solid gray; border-radius: 5px; clear:both ">

            <table style="width: 100%;">
                <tr>
                    <th>Today Sale Receipts</th>
                    <th style="text-align: right;">Search By Receipt No:
                        <input type="text" name="search_receipt_no" id="search_receipt_no" />
                    </th>
                </tr>

            </table>

        </div>

        <div id="receipt_list">
        </div>

        <div>
            <h3>Today Sale and Return Receipts</h3>
            <?php $this->load->view(ADMIN_DIR . "sale_point/receipt_lists");  ?>

        </div>


    </div>

    <div class="col-sm-4">
        <div id="customer_recipt"></div>
    </div>
</div>