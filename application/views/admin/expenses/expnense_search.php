<div class="container" style="margin-top:5px !important; font-size:10px;">
  <div class="row">
    <!-- MESSENGER -->
    <div class="col-md-4">




      <div class="box border blue" id="messenger">
        <div class="box-title">
          <h4 class="pull-left">Search</h4>
        </div>
        <div class="box-body">
          <form role="form" method="post" action="<?php echo site_url(ADMIN_DIR . "expenses/search_expenses") ?>">



            <div class="form-group">
              <input type="date" name="start_date" value="" required="required" />
              <input type="date" name="end_date" value="" required="required" />
              <button type="submit">Search</button>
            </div>



          </form>
        </div>
      </div>



    </div>
    <!-- /MESSENGER -->

    <div class="col-md-8">
      <div class="box border blue" id="messenger">
        <div class="box-title">
          <h4 class="pull-left">Today Expenses List</h4>
          <h4 class="pull-right" style="color:#FF0 !important;"><em>Today Total Expenses: Rs</em> <?php echo $total_expenses; ?></h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="expenses_table">
              <thead>
                <tr>
                  <td>#</td>
                  <th><?php echo $this->lang->line('expense_amount'); ?></th>
                  <th><?php echo $this->lang->line('expense_title'); ?></th>
                  <th><?php echo $this->lang->line('expense_description'); ?></th>
                  <th><?php echo $this->lang->line('expense_attachment'); ?></th>
                  <th><?php echo $this->lang->line('expense_type'); ?></th>
                  <th>Date</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $count = 1;

                foreach ($expenses as $expense) : ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $expense->expense_amount; ?></td>
                    <td><?php echo $expense->expense_title; ?></td>
                    <td><?php echo $expense->expense_description; ?></td>
                    <td><?php
                        echo file_type(base_url("assets/uploads/" . $expense->expense_attachment));
                        ?></td>
                    <td><?php echo $expense->expense_type; ?></td>

                    <td><?php echo date("d M, Y", strtotime($expense->created_date)); ?></td>

                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <?php //echo $pagination; 
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css" />

<script>
  $(document).ready(function() {
    $('#expenses_table').DataTable({
      "bPaginate": false,

    });
  });
</script>