<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Patients extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/patient_model");
        $this->lang->load("patients", 'english');
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

        $where = "`patients`.`status` IN (0, 1) ";
        $data = $this->patient_model->get_patient_list($where);
        $this->data["patients"] = $data->patients;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Patients');
        $this->data["view"] = ADMIN_DIR . "patients/patients";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_patient($patient_id)
    {

        $patient_id = (int) $patient_id;

        $this->data["patients"] = $this->patient_model->get_patient($patient_id);
        $this->data["title"] = $this->lang->line('Patient Details');
        $this->data["view"] = ADMIN_DIR . "patients/view_patient";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`patients`.`status` IN (2) ";
        $data = $this->patient_model->get_patient_list($where);
        $this->data["patients"] = $data->patients;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Patients');
        $this->data["view"] = ADMIN_DIR . "patients/trashed_patients";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($patient_id, $page_id = NULL)
    {

        $patient_id = (int) $patient_id;


        $this->patient_model->changeStatus($patient_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "patients/view/" . $page_id);
    }

    /**
     * function to restor patient from trash
     * @param $patient_id integer
     */
    public function restore($patient_id, $page_id = NULL)
    {

        $patient_id = (int) $patient_id;


        $this->patient_model->changeStatus($patient_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "patients/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft patient from trash
     * @param $patient_id integer
     */
    public function draft($patient_id, $page_id = NULL)
    {

        $patient_id = (int) $patient_id;


        $this->patient_model->changeStatus($patient_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "patients/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish patient from trash
     * @param $patient_id integer
     */
    public function publish($patient_id, $page_id = NULL)
    {

        $patient_id = (int) $patient_id;


        $this->patient_model->changeStatus($patient_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "patients/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Patient
     * @param $patient_id integer
     */
    public function delete($patient_id, $page_id = NULL)
    {

        $patient_id = (int) $patient_id;
        $this->patient_model->changeStatus($patient_id, "3");

        //$this->patient_model->delete(array( 'patient_id' => $patient_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "patients/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Patient
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Patient');
        $this->data["view"] = ADMIN_DIR . "patients/add_patient";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->patient_model->validate_form_data() === TRUE) {

            $patient_id = $this->patient_model->save_data();
            if ($patient_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "patients/edit/$patient_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "patients/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Patient
     */
    public function edit($patient_id)
    {
        $patient_id = (int) $patient_id;
        $this->data["patient"] = $this->patient_model->get($patient_id);

        $this->data["title"] = $this->lang->line('Edit Patient');
        $this->data["view"] = ADMIN_DIR . "patients/edit_patient";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($patient_id)
    {

        $patient_id = (int) $patient_id;

        if ($this->patient_model->validate_form_data() === TRUE) {

            $patient_id = $this->patient_model->update_data($patient_id);
            if ($patient_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "patients/edit/$patient_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "patients/edit/$patient_id");
            }
        } else {
            $this->edit($patient_id);
        }
    }


    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["patients"] = $this->patient_model->getBy($where, false, "patient_id");
        $j_array[] = array("id" => "", "value" => "patient");
        foreach ($data["patients"] as $patient) {
            $j_array[] = array("id" => $patient->patient_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
