<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Patient_tests extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/patient_test_model");
        $this->lang->load("patient_tests", 'english');
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

        $where = "`patient_tests`.`status` IN (0, 1) ";
        $data = $this->patient_test_model->get_patient_test_list($where);
        $this->data["patient_tests"] = $data->patient_tests;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Patient Tests');
        $this->data["view"] = ADMIN_DIR . "patient_tests/patient_tests";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_patient_test($patient_test_id)
    {

        $patient_test_id = (int) $patient_test_id;

        $this->data["patient_tests"] = $this->patient_test_model->get_patient_test($patient_test_id);
        $this->data["title"] = $this->lang->line('Patient Test Details');
        $this->data["view"] = ADMIN_DIR . "patient_tests/view_patient_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`patient_tests`.`status` IN (2) ";
        $data = $this->patient_test_model->get_patient_test_list($where);
        $this->data["patient_tests"] = $data->patient_tests;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Patient Tests');
        $this->data["view"] = ADMIN_DIR . "patient_tests/trashed_patient_tests";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($patient_test_id, $page_id = NULL)
    {

        $patient_test_id = (int) $patient_test_id;


        $this->patient_test_model->changeStatus($patient_test_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "patient_tests/view/" . $page_id);
    }

    /**
     * function to restor patient_test from trash
     * @param $patient_test_id integer
     */
    public function restore($patient_test_id, $page_id = NULL)
    {

        $patient_test_id = (int) $patient_test_id;


        $this->patient_test_model->changeStatus($patient_test_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "patient_tests/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft patient_test from trash
     * @param $patient_test_id integer
     */
    public function draft($patient_test_id, $page_id = NULL)
    {

        $patient_test_id = (int) $patient_test_id;


        $this->patient_test_model->changeStatus($patient_test_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "patient_tests/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish patient_test from trash
     * @param $patient_test_id integer
     */
    public function publish($patient_test_id, $page_id = NULL)
    {

        $patient_test_id = (int) $patient_test_id;


        $this->patient_test_model->changeStatus($patient_test_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "patient_tests/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Patient_test
     * @param $patient_test_id integer
     */
    public function delete($patient_test_id, $page_id = NULL)
    {

        $patient_test_id = (int) $patient_test_id;
        //$this->patient_test_model->changeStatus($patient_test_id, "3");

        //$this->patient_test_model->delete(array( 'patient_test_id' => $patient_test_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "patient_tests/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Patient_test
     */
    public function add()
    {

        $this->data["invoices"] = $this->patient_test_model->getList("invoices", "invoice_id", "invoice_id", $where = "`invoices`.`status` IN (1) ");

        $this->data["tests"] = $this->patient_test_model->getList("tests", "test_id", "test_name", $where = "`tests`.`status` IN (1) ");

        $this->data["title"] = $this->lang->line('Add New Patient Test');
        $this->data["view"] = ADMIN_DIR . "patient_tests/add_patient_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->patient_test_model->validate_form_data() === TRUE) {

            $patient_test_id = $this->patient_test_model->save_data();
            if ($patient_test_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "patient_tests/edit/$patient_test_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "patient_tests/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Patient_test
     */
    public function edit($patient_test_id)
    {
        $patient_test_id = (int) $patient_test_id;
        $this->data["patient_test"] = $this->patient_test_model->get($patient_test_id);

        $this->data["invoices"] = $this->patient_test_model->getList("invoices", "invoice_id", "invoice_id", $where = "`invoices`.`status` IN (1) ");

        $this->data["tests"] = $this->patient_test_model->getList("tests", "test_id", "test_name", $where = "`tests`.`status` IN (1) ");

        $this->data["title"] = $this->lang->line('Edit Patient Test');
        $this->data["view"] = ADMIN_DIR . "patient_tests/edit_patient_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($patient_test_id)
    {

        $patient_test_id = (int) $patient_test_id;

        if ($this->patient_test_model->validate_form_data() === TRUE) {

            $patient_test_id = $this->patient_test_model->update_data($patient_test_id);
            if ($patient_test_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "patient_tests/edit/$patient_test_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "patient_tests/edit/$patient_test_id");
            }
        } else {
            $this->edit($patient_test_id);
        }
    }


    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["patient_tests"] = $this->patient_test_model->getBy($where, false, "patient_test_id");
        $j_array[] = array("id" => "", "value" => "patient_test");
        foreach ($data["patient_tests"] as $patient_test) {
            $j_array[] = array("id" => $patient_test->patient_test_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
