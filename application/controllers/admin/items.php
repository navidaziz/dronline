<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Items extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/item_model");
        $this->lang->load("items", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {
        $main_page = base_url() . ADMIN_DIR . $this->router->fetch_class() . "/view";
        redirect($main_page);
    }
    //---------------------------------------------------------------

    public function update_cost_price()
    {
        $item_id = (int) $this->input->post("item_id");
        $cost_price =  (float) $this->input->post("cost_price");
        $profit_percetage = "12";
        $sale_price = round(($cost_price * (100 + $profit_percetage) / 100), 2);
        $query = "UPDATE items SET cost_price ='" . $cost_price . "'
        WHERE item_id = '" . $item_id . "'";
        if ($this->db->query($query)) {

            echo $cost_price;
        }
    }

    public function update_unit_price()
    {
        $item_id = (int) $this->input->post("item_id");
        $unit_price =  (float) $this->input->post("unit_price");
        $query = "UPDATE items SET unit_price ='" . $unit_price . "'
        WHERE item_id = '" . $item_id . "'";
        if ($this->db->query($query)) {

            echo $unit_price;
        }
    }




    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {

        //$where = "`items`.`status` IN (0, 1) ";
        //$data = $this->item_model->get_item_list($where);
        //$this->data["items"] = $data->items;
        //$this->data["pagination"] = $data->pagination;
        $query = "SELECT * FROM all_items WHERE `status` IN (0, 1)";
        $this->data["items"] = $this->db->query($query)->result();
        $this->data["title"] = $this->lang->line('Items');
        $this->data["view"] = ADMIN_DIR . "items/items";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_item($item_id)
    {

        $item_id = (int) $item_id;

        $this->data["items"] = $this->item_model->get_item($item_id);
        $this->data["title"] = $this->lang->line('Item Details');
        $this->data["view"] = ADMIN_DIR . "items/view_item";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`items`.`status` IN (2) ";
        $data = $this->item_model->get_item_list($where);
        $this->data["items"] = $data->items;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Items');
        $this->data["view"] = ADMIN_DIR . "items/trashed_items";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($item_id, $page_id = NULL)
    {

        $item_id = (int) $item_id;


        $this->item_model->changeStatus($item_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "items/view/" . $page_id);
    }

    /**
     * function to restor item from trash
     * @param $item_id integer
     */
    public function restore($item_id, $page_id = NULL)
    {

        $item_id = (int) $item_id;


        $this->item_model->changeStatus($item_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "items/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft item from trash
     * @param $item_id integer
     */
    public function draft($item_id, $page_id = NULL)
    {

        $item_id = (int) $item_id;


        $this->item_model->changeStatus($item_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "items/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish item from trash
     * @param $item_id integer
     */
    public function publish($item_id, $page_id = NULL)
    {

        $item_id = (int) $item_id;


        $this->item_model->changeStatus($item_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "items/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Item
     * @param $item_id integer
     */
    public function delete($item_id, $page_id = NULL)
    {

        $item_id = (int) $item_id;
        $this->item_model->changeStatus($item_id, "3");

        //$this->item_model->delete(array('item_id' => $item_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "items/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Item
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Item');
        $this->data["view"] = ADMIN_DIR . "items/add_item";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {

        if ($this->item_model->validate_form_data(true) === TRUE) {

            $item_id = $this->item_model->save_data();
            if ($item_id) {
                $cost_price = $this->input->post("cost_price");
                $unit_price = $this->input->post("unit_price");
                $supplier_id = $this->input->post("supplier_id");
                $created_by = $this->session->userdata("user_id");
                $date = date('Y-m-d', time());


                //update item enventory after first time add 
                $query = "INSERT INTO `inventory`(`item_id`, `supplier_id`, `item_cost_price`, `item_unit_price`, `transaction_type`, `inventory_transaction`,`created_by`, `expiry_date`) 
                            VALUES ('" . $item_id . "', '" . $supplier_id . "', '" . $cost_price . "', '" . $unit_price . "', 'Item Created','0','" . $created_by . "', '" . $date . "')";
                $this->db->query($query);
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "items/edit/$item_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "items/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Item
     */
    public function edit($item_id)
    {
        $item_id = (int) $item_id;
        $this->data["item"] = $this->item_model->get($item_id);

        $this->data["title"] = $this->lang->line('Edit Item');
        $this->data["view"] = ADMIN_DIR . "items/edit_item";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($item_id)
    {

        $item_id = (int) $item_id;

        if ($this->item_model->validate_form_data() === TRUE) {

            $item_id = $this->item_model->update_data($item_id);
            if ($item_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "items/edit/$item_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "items/edit/$item_id");
            }
        } else {
            $this->edit($item_id);
        }
    }

    function get_item_detail()
    {
        $item_id = (int) $this->input->post("item_id");
        $query = "SELECT * FROM all_items WHERE item_id = '" . $item_id . "'";
        $this->data["items"] = $this->db->query($query)->result();
        $this->data["suppliers"] = $this->item_model->getList("suppliers", "supplier_id", "supplier_name", "`suppliers`.`status` IN (1)");

        $query = "SELECT inventory.*, items.name, users.user_title FROM inventory, items, users 
                  WHERE inventory.item_id = items.item_id
                  AND inventory.created_by = users.user_id
                  AND inventory.item_id = '" . $item_id . "'
                  ORDER BY inventory.inventory_id DESC";
        $this->data['inventories'] = $this->db->query($query)->result();
        $this->data["title"] = $this->lang->line('Item Details');
        $this->load->view(ADMIN_DIR . "items/item_detail", $this->data);
    }

    function add_item_stocks()
    {
        $item_id = (int) $this->input->post("item_id");

        $supplier_invoice_id = $this->input->post("supplier_invoice_id");
        $batch_number = $this->input->post("batch_number");
        $cost_price = $this->input->post("cost_price");
        $unit_price = $this->input->post("unit_price");
        $supplier_id = $this->input->post("supplier_id");
        $transaction = $this->input->post("transaction");
        $date = $this->input->post("date");
        $created_by = $this->session->userdata("user_id");

        //update item enventory after first time add 
        $query = "INSERT INTO `inventory`(`item_id`, 
                                          `supplier_id`,
                                          `supplier_invoice_id`, 
                                          `batch_number`, 
                                          `item_cost_price`, 
                                          `item_unit_price`, 
                                          `transaction_type`, 
                                          `inventory_transaction`,
                                          `expiry_date`,`created_by`) 
                            VALUES ('" . $item_id . "', 
                                    '" . $supplier_id . "', 
                                    '" . $supplier_invoice_id . "', 
                                    '" . $batch_number . "', 
                                    '" . $cost_price . "', 
                                    '" . $unit_price . "', 
                                    'Stock In',
                                    '" . $transaction . "',
                                    '" . $date . "',
                                    '" . $created_by . "')";
        $this->db->query($query);
        $query = "
        UPDATE `items` SET `cost_price` = '" . $cost_price . "',  
        `unit_price` = '" . $unit_price . "'
        WHERE `items`.`item_id` ='" . $item_id . "'";
        $this->db->query($query);
        $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
        redirect(ADMIN_DIR . "items/view");
    }

    function return_item_stocks()
    {
        $item_id = (int) $this->input->post("item_id");
        $transaction = $this->input->post("transaction");
        $supplier_invoice_id = $this->input->post("supplier_invoice_id");
        $batch_number = $this->input->post("batch_number");
        $cost_price = $this->input->post("cost_price");
        $unit_price = $this->input->post("unit_price");
        $supplier_id = $this->input->post("supplier_id");

        $date = $this->input->post("date");
        $created_by = $this->session->userdata("user_id");
        $remarks = $this->input->post("remarks");

        $query = "SELECT `total_quantity`, `name` FROM `all_items` WHERE `item_id`='" . $item_id . "'";
        $query_result = $this->db->query($query)->result();
        if ($query_result) {
            if ($query_result[0]->total_quantity >= $transaction) {


                //update item enventory after first time add 
                $query = "INSERT INTO `inventory`(`item_id`, 
                                              `supplier_id`,
                                              `supplier_invoice_id`, 
                                              `batch_number`, 
                                              `item_cost_price`, 
                                              `item_unit_price`, 
                                              `transaction_type`, 
                                              `inventory_transaction`,
                                              `return_date`,
                                              `created_by`,
                                              `remarks`) 
                                VALUES ('" . $item_id . "', 
                                        '" . $supplier_id . "', 
                                        '" . $supplier_invoice_id . "', 
                                        '" . $batch_number . "', 
                                        '" . $cost_price . "', 
                                        '" . $unit_price . "', 
                                        'Stock Return',
                                        '-" . $transaction . "',
                                        '" . $date . "',
                                        '" . $created_by . "',
                                        '" . $remarks . "')";

                $this->db->query($query);
                $query = "
                UPDATE `items` SET `cost_price` = '" . $cost_price . "',  
                `unit_price` = '" . $unit_price . "'
                WHERE `items`.`item_id` ='" . $item_id . "'";
                $this->db->query($query);
                $this->session->set_flashdata("msg_success", "Record Add Successfully");
            } else {
                if ($query_result[0]->total_quantity) {
                    $this->session->set_flashdata("msg_error", $query_result[0]->name . " only " . $query_result[0]->total_quantity . " remain in stock. you can't return more then in stock value.");
                } else {
                    $this->session->set_flashdata("msg_error", $query_result[0]->name . " is not in stock");
                }
            }
        } else {
            $this->session->set_flashdata("msg_error", "Item not found");
        }

        redirect(ADMIN_DIR . "items/view/");
    }
}
