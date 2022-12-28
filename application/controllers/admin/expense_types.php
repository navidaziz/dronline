<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Expense_types extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/expense_type_model");
        $this->lang->load("expense_types", 'english');
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



    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {

        $where = "`expense_types`.`status` IN (0, 1) ";
        $data = $this->expense_type_model->get_expense_type_list($where);
        $this->data["expense_types"] = $data->expense_types;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Expense Types');
        $this->data["view"] = ADMIN_DIR . "expense_types/expense_types";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_expense_type($expense_type_id)
    {

        $expense_type_id = (int) $expense_type_id;

        $this->data["expense_types"] = $this->expense_type_model->get_expense_type($expense_type_id);
        $this->data["title"] = $this->lang->line('Expense Type Details');
        $this->data["view"] = ADMIN_DIR . "expense_types/view_expense_type";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`expense_types`.`status` IN (2) ";
        $data = $this->expense_type_model->get_expense_type_list($where);
        $this->data["expense_types"] = $data->expense_types;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Expense Types');
        $this->data["view"] = ADMIN_DIR . "expense_types/trashed_expense_types";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($expense_type_id, $page_id = NULL)
    {

        $expense_type_id = (int) $expense_type_id;


        $this->expense_type_model->changeStatus($expense_type_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "expense_types/view/" . $page_id);
    }

    /**
     * function to restor expense_type from trash
     * @param $expense_type_id integer
     */
    public function restore($expense_type_id, $page_id = NULL)
    {

        $expense_type_id = (int) $expense_type_id;


        $this->expense_type_model->changeStatus($expense_type_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "expense_types/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft expense_type from trash
     * @param $expense_type_id integer
     */
    public function draft($expense_type_id, $page_id = NULL)
    {

        $expense_type_id = (int) $expense_type_id;


        $this->expense_type_model->changeStatus($expense_type_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "expense_types/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish expense_type from trash
     * @param $expense_type_id integer
     */
    public function publish($expense_type_id, $page_id = NULL)
    {

        $expense_type_id = (int) $expense_type_id;


        $this->expense_type_model->changeStatus($expense_type_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "expense_types/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Expense_type
     * @param $expense_type_id integer
     */
    public function delete($expense_type_id, $page_id = NULL)
    {

        $expense_type_id = (int) $expense_type_id;
        $this->expense_type_model->changeStatus($expense_type_id, "3");

        //$this->expense_type_model->delete(array( 'expense_type_id' => $expense_type_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "expense_types/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Expense_type
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Expense Type');
        $this->data["view"] = ADMIN_DIR . "expense_types/add_expense_type";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->expense_type_model->validate_form_data() === TRUE) {

            $expense_type_id = $this->expense_type_model->save_data();
            if ($expense_type_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "expense_types/edit/$expense_type_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "expense_types/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Expense_type
     */
    public function edit($expense_type_id)
    {
        $expense_type_id = (int) $expense_type_id;
        $this->data["expense_type"] = $this->expense_type_model->get($expense_type_id);

        $this->data["title"] = $this->lang->line('Edit Expense Type');
        $this->data["view"] = ADMIN_DIR . "expense_types/edit_expense_type";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($expense_type_id)
    {

        $expense_type_id = (int) $expense_type_id;

        if ($this->expense_type_model->validate_form_data() === TRUE) {

            $expense_type_id = $this->expense_type_model->update_data($expense_type_id);
            if ($expense_type_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "expense_types/edit/$expense_type_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "expense_types/edit/$expense_type_id");
            }
        } else {
            $this->edit($expense_type_id);
        }
    }


    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["expense_types"] = $this->expense_type_model->getBy($where, false, "expense_type_id");
        $j_array[] = array("id" => "", "value" => "expense_type");
        foreach ($data["expense_types"] as $expense_type) {
            $j_array[] = array("id" => $expense_type->expense_type_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
