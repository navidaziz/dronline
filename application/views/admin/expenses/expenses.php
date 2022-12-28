<div class="container" style="margin-top:5px !important; font-size:10px;">
  <div class="row">
    <!-- MESSENGER -->
    <div class="col-md-4">
      <div class="box border blue" id="messenger">
        <div class="box-title">
          <h4> Add Expense</h4>
        </div>
        <div class="box-body">
          <?php
          $add_form_attr = array("class" => "form-horizontal");
          echo form_open_multipart(ADMIN_DIR . "expenses/save_data", $add_form_attr);
          ?>
          <div class="form-group">
            <?php
            $label = array(
              "class" => "col-md-2 control-label",
              "style" => "",
            );
            echo form_label($this->lang->line('expense_type'), "Expense Type Id", $label);
            ?>
            <div class="col-md-10">
              <?php
              echo form_dropdown("expense_type_id", $expense_types, "", "class=\"form-control\" required style=\"\"");
              ?>
              <button type="button" class="btn btn-link btn-small" data-toggle="modal" data-target="#expense_model">Add New Expense Type</button>
            </div>
            <?php echo form_error("expense_type_id", "<p class=\"text-danger\">", "</p>"); ?>
          </div>
          <div class="form-group">
            <?php
            $label = array(
              "class" => "col-md-2 control-label",
              "style" => "",
            );
            echo form_label($this->lang->line('expense_amount'), "expense_amount", $label);      ?>
            <div class="col-md-10">
              <?php

              $number = array(
                "type"          =>  "number",
                "name"          =>  "expense_amount",
                "id"            =>  "expense_amount",
                "class"         =>  "form-control",
                "style"         =>  "", "required"    => "required", "title"         =>  $this->lang->line('expense_amount'),
                "value"         =>  set_value("expense_amount"),
                "placeholder"   =>  $this->lang->line('expense_amount')
              );
              echo  form_input($number);
              ?>
              <?php echo form_error("expense_amount", "<p class=\"text-danger\">", "</p>"); ?> </div>
          </div>
          <div class="form-group">
            <?php
            $label = array(
              "class" => "col-md-2 control-label",
              "style" => "",
            );
            echo form_label($this->lang->line('expense_title'), "expense_title", $label);      ?>
            <div class="col-md-10">
              <?php

              $text = array(
                "type"          =>  "text",
                "name"          =>  "expense_title",
                "id"            =>  "expense_title",
                "class"         =>  "form-control",
                "style"         =>  "", "required"    => "required", "title"         =>  $this->lang->line('expense_title'),
                "value"         =>  set_value("expense_title"),
                "placeholder"   =>  $this->lang->line('expense_title')
              );
              echo  form_input($text);
              ?>
              <?php echo form_error("expense_title", "<p class=\"text-danger\">", "</p>"); ?> </div>
          </div>
          <div class="form-group">
            <?php
            $label = array(
              "class" => "col-md-2 control-label",
              "style" => "",
            );
            echo form_label($this->lang->line('expense_description'), "expense_description", $label);
            ?>
            <div class="col-md-10">
              <?php

              $textarea = array(
                "name"          =>  "expense_description",
                "id"            =>  "expense_description",
                "class"         =>  "form-control",
                "style"         =>  "",
                "title"         =>  $this->lang->line('expense_description'), "required"    => "required",
                "rows"          =>  "",
                "cols"          =>  "",
                "value"         => set_value("expense_description"),
                "placeholder"   =>  $this->lang->line('expense_description')
              );
              echo form_textarea($textarea);
              ?>
              <?php echo form_error("expense_description", "<p class=\"text-danger\">", "</p>"); ?> </div>
          </div>
          <div class="form-group">
            <?php
            $label = array(
              "class" => "col-md-2 control-label",
              "style" => "",
            );
            echo form_label($this->lang->line('expense_attachment'), "expense_attachment", $label);      ?>
            <div class="col-md-10">
              <?php

              $file = array(
                "type"          =>  "file",
                "name"          =>  "expense_attachment",
                "id"            =>  "expense_attachment",
                "class"         =>  "form-control",
                "style"         =>  "", "title"         =>  $this->lang->line('expense_attachment'),
                "value"         =>  set_value("expense_attachment"),
                "placeholder"   =>  $this->lang->line('expense_attachment')
              );
              echo  form_input($file);
              ?>
              <?php echo form_error("expense_attachment", "<p class=\"text-danger\">", "</p>"); ?> </div>
          </div>
          <div class="col-md-12"> <span class="pull-left"> </span> <span class="pull-right">
              <?php
              $submit = array(
                "type"  =>  "submit",
                "name"  =>  "submit",
                "value" =>  $this->lang->line('Save'),
                "class" =>  "btn btn-primary",
                "style" =>  ""
              );
              echo form_submit($submit);
              ?>
              <?php
              $reset = array(
                "type"  =>  "reset",
                "name"  =>  "reset",
                "value" =>  $this->lang->line('Reset'),
                "class" =>  "btn btn-default",
                "style" =>  ""
              );
              echo form_reset($reset);
              ?>
            </span> </div>
          <div style="clear:both;"></div>
          <?php echo form_close(); ?>
        </div>
      </div>



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
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td>#</td>
                  <th><?php echo $this->lang->line('expense_amount'); ?></th>
                  <th><?php echo $this->lang->line('expense_title'); ?></th>
                  <th><?php echo $this->lang->line('expense_description'); ?></th>
                  <th><?php echo $this->lang->line('expense_attachment'); ?></th>
                  <th><?php echo $this->lang->line('expense_type'); ?></th>


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


                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <?php echo $pagination; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="expense_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="test_form_title">Add Expense Type</h4>
      </div>
      <div class="modal-body">

        <div class="box-body">

          <?php
          $add_form_attr = array("class" => "form-horizontal");
          echo form_open_multipart(ADMIN_DIR . "expenses/save_expense_type", $add_form_attr);
          ?>

          <div class="form-group">

            <?php
            $label = array(
              "class" => "col-md-2 control-label",
              "style" => "",
            );
            echo form_label($this->lang->line('expense_type'), "expense_type", $label);      ?>

            <div class="col-md-10">
              <?php

              $text = array(
                "type"          =>  "text",
                "name"          =>  "expense_type",
                "id"            =>  "expense_type",
                "class"         =>  "form-control",
                "style"         =>  "", "required"      => "required", "title"         =>  $this->lang->line('expense_type'),
                "value"         =>  set_value("expense_type"),
                "placeholder"   =>  $this->lang->line('expense_type')
              );
              echo  form_input($text);
              ?>
              <?php echo form_error("expense_type", "<p class=\"text-danger\">", "</p>"); ?>
            </div>



          </div>

          <div class="col-md-offset-2 col-md-10">
            <?php
            $submit = array(
              "type"  =>  "submit",
              "name"  =>  "submit",
              "value" =>  $this->lang->line('Save'),
              "class" =>  "btn btn-primary",
              "style" =>  ""
            );
            echo form_submit($submit);
            ?>



            <?php
            $reset = array(
              "type"  =>  "reset",
              "name"  =>  "reset",
              "value" =>  $this->lang->line('Reset'),
              "class" =>  "btn btn-default",
              "style" =>  ""
            );
            echo form_reset($reset);
            ?>
          </div>
          <div style="clear:both;"></div>

          <?php echo form_close(); ?>

        </div>


      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>