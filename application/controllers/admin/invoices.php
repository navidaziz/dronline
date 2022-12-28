<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/invoice_model");
        $this->lang->load("invoices", 'english');
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

        $where = "`invoices`.`status` IN (0, 1) ORDER BY `invoices`.`order`";
        $data = $this->invoice_model->get_invoice_list($where);
        $this->data["invoices"] = $data->invoices;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Invoices');
        $this->data["view"] = ADMIN_DIR . "invoices/invoices";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_invoice($invoice_id)
    {

        $invoice_id = (int) $invoice_id;

        $this->data["invoices"] = $this->invoice_model->get_invoice($invoice_id);
        $this->data["title"] = $this->lang->line('Invoice Details');
        $this->data["view"] = ADMIN_DIR . "invoices/view_invoice";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`invoices`.`status` IN (2) ORDER BY `invoices`.`order`";
        $data = $this->invoice_model->get_invoice_list($where);
        $this->data["invoices"] = $data->invoices;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Invoices');
        $this->data["view"] = ADMIN_DIR . "invoices/trashed_invoices";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($invoice_id, $page_id = NULL)
    {

        $invoice_id = (int) $invoice_id;


        $this->invoice_model->changeStatus($invoice_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "invoices/view/" . $page_id);
    }

    /**
     * function to restor invoice from trash
     * @param $invoice_id integer
     */
    public function restore($invoice_id, $page_id = NULL)
    {

        $invoice_id = (int) $invoice_id;


        $this->invoice_model->changeStatus($invoice_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "invoices/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft invoice from trash
     * @param $invoice_id integer
     */
    public function draft($invoice_id, $page_id = NULL)
    {

        $invoice_id = (int) $invoice_id;


        $this->invoice_model->changeStatus($invoice_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "invoices/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish invoice from trash
     * @param $invoice_id integer
     */
    public function publish($invoice_id, $page_id = NULL)
    {

        $invoice_id = (int) $invoice_id;


        $this->invoice_model->changeStatus($invoice_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "invoices/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Invoice
     * @param $invoice_id integer
     */
    public function delete($invoice_id, $page_id = NULL)
    {

        $invoice_id = (int) $invoice_id;
        //$this->invoice_model->changeStatus($invoice_id, "3");

        //$this->invoice_model->delete(array( 'invoice_id' => $invoice_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "invoices/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Invoice
     */
    public function add()
    {

        $this->data["patients"] = $this->invoice_model->getList("patients", "patient_id", "patient_name", $where = "`patients`.`status` IN (1) ");

        $this->data["doctors"] = $this->invoice_model->getList("doctors", "doctor_id", "doctor_name", $where = "`doctors`.`status` IN (1) ");

        $this->data["title"] = $this->lang->line('Add New Invoice');
        $this->data["view"] = ADMIN_DIR . "invoices/add_invoice";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->invoice_model->validate_form_data() === TRUE) {

            $invoice_id = $this->invoice_model->save_data();
            if ($invoice_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "invoices/edit/$invoice_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "invoices/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Invoice
     */
    public function edit($invoice_id)
    {
        $invoice_id = (int) $invoice_id;
        $this->data["invoice"] = $this->invoice_model->get($invoice_id);

        $this->data["patients"] = $this->invoice_model->getList("patients", "patient_id", "patient_name", $where = "`patients`.`status` IN (1) ");

        $this->data["doctors"] = $this->invoice_model->getList("doctors", "doctor_id", "doctor_name", $where = "`doctors`.`status` IN (1) ");

        $this->data["title"] = $this->lang->line('Edit Invoice');
        $this->data["view"] = ADMIN_DIR . "invoices/edit_invoice";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($invoice_id)
    {

        $invoice_id = (int) $invoice_id;

        if ($this->invoice_model->validate_form_data() === TRUE) {

            $invoice_id = $this->invoice_model->update_data($invoice_id);
            if ($invoice_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "invoices/edit/$invoice_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "invoices/edit/$invoice_id");
            }
        } else {
            $this->edit($invoice_id);
        }
    }


    /**
     * function to move a record up in list
     * @param $invoice_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($invoice_id, $page_id = NULL)
    {

        $invoice_id = (int) $invoice_id;

        //get order number of this record
        $this_invoice_where = "invoice_id = $invoice_id";
        $this_invoice = $this->invoice_model->getBy($this_invoice_where, true);
        $this_invoice_id = $invoice_id;
        $this_invoice_order = $this_invoice->order;


        //get order number of previous record
        $previous_invoice_where = "order <= $this_invoice_order AND invoice_id != $invoice_id ORDER BY `order` DESC";
        $previous_invoice = $this->invoice_model->getBy($previous_invoice_where, true);
        $previous_invoice_id = $previous_invoice->invoice_id;
        $previous_invoice_order = $previous_invoice->order;

        //if this is the first element
        if (!$previous_invoice_id) {
            redirect(ADMIN_DIR . "invoices/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_invoice_inputs = array(
            "order" => $previous_invoice_order
        );
        $this->invoice_model->save($this_invoice_inputs, $this_invoice_id);

        $previous_invoice_inputs = array(
            "order" => $this_invoice_order
        );
        $this->invoice_model->save($previous_invoice_inputs, $previous_invoice_id);



        redirect(ADMIN_DIR . "invoices/view/" . $page_id);
    }
    //-------------------------------------------------------------------------------------

    /**
     * function to move a record up in list
     * @param $invoice_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($invoice_id, $page_id = NULL)
    {

        $invoice_id = (int) $invoice_id;



        //get order number of this record
        $this_invoice_where = "invoice_id = $invoice_id";
        $this_invoice = $this->invoice_model->getBy($this_invoice_where, true);
        $this_invoice_id = $invoice_id;
        $this_invoice_order = $this_invoice->order;


        //get order number of next record

        $next_invoice_where = "order >= $this_invoice_order and invoice_id != $invoice_id ORDER BY `order` ASC";
        $next_invoice = $this->invoice_model->getBy($next_invoice_where, true);
        $next_invoice_id = $next_invoice->invoice_id;
        $next_invoice_order = $next_invoice->order;

        //if this is the first element
        if (!$next_invoice_id) {
            redirect(ADMIN_DIR . "invoices/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_invoice_inputs = array(
            "order" => $next_invoice_order
        );
        $this->invoice_model->save($this_invoice_inputs, $this_invoice_id);

        $next_invoice_inputs = array(
            "order" => $this_invoice_order
        );
        $this->invoice_model->save($next_invoice_inputs, $next_invoice_id);



        redirect(ADMIN_DIR . "invoices/view/" . $page_id);
    }

    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["invoices"] = $this->invoice_model->getBy($where, false, "invoice_id");
        $j_array[] = array("id" => "", "value" => "invoice");
        foreach ($data["invoices"] as $invoice) {
            $j_array[] = array("id" => $invoice->invoice_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
