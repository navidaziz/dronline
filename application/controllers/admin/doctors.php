<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Doctors extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/doctor_model");
        $this->lang->load("doctors", 'english');
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

        $where = "`doctors`.`status` IN (0, 1) ORDER BY `doctors`.`order`";
        $this->data["doctors"] = $this->doctor_model->get_doctor_list($where, false);
        $this->data["pagination"] = "";
        $this->data["title"] = $this->lang->line('Doctors');
        $this->data["view"] = ADMIN_DIR . "doctors/doctors";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_doctor($doctor_id)
    {

        $doctor_id = (int) $doctor_id;

        $this->data["doctors"] = $this->doctor_model->get_doctor($doctor_id);
        $this->data["title"] = $this->lang->line('Doctor Details');
        $this->data["view"] = ADMIN_DIR . "doctors/view_doctor";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`doctors`.`status` IN (2) ORDER BY `doctors`.`order`";
        $data = $this->doctor_model->get_doctor_list($where);
        $this->data["doctors"] = $data->doctors;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Doctors');
        $this->data["view"] = ADMIN_DIR . "doctors/trashed_doctors";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($doctor_id, $page_id = NULL)
    {

        $doctor_id = (int) $doctor_id;


        $this->doctor_model->changeStatus($doctor_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "doctors/view/" . $page_id);
    }

    /**
     * function to restor doctor from trash
     * @param $doctor_id integer
     */
    public function restore($doctor_id, $page_id = NULL)
    {

        $doctor_id = (int) $doctor_id;


        $this->doctor_model->changeStatus($doctor_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "doctors/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft doctor from trash
     * @param $doctor_id integer
     */
    public function draft($doctor_id, $page_id = NULL)
    {

        $doctor_id = (int) $doctor_id;


        $this->doctor_model->changeStatus($doctor_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "doctors/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish doctor from trash
     * @param $doctor_id integer
     */
    public function publish($doctor_id, $page_id = NULL)
    {

        $doctor_id = (int) $doctor_id;


        $this->doctor_model->changeStatus($doctor_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "doctors/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Doctor
     * @param $doctor_id integer
     */
    public function delete($doctor_id, $page_id = NULL)
    {

        $doctor_id = (int) $doctor_id;
        $this->doctor_model->changeStatus($doctor_id, "3");

        //$this->doctor_model->delete(array( 'doctor_id' => $doctor_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "doctors/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Doctor
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Doctor');
        $this->data["view"] = ADMIN_DIR . "doctors/add_doctor";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->doctor_model->validate_form_data() === TRUE) {

            $doctor_id = $this->doctor_model->save_data();
            if ($doctor_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "doctors/edit/$doctor_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "doctors/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Doctor
     */
    public function edit($doctor_id)
    {
        $doctor_id = (int) $doctor_id;
        $this->data["doctor"] = $this->doctor_model->get($doctor_id);

        $this->data["title"] = $this->lang->line('Edit Doctor');
        $this->data["view"] = ADMIN_DIR . "doctors/edit_doctor";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($doctor_id)
    {

        $doctor_id = (int) $doctor_id;

        if ($this->doctor_model->validate_form_data() === TRUE) {

            $doctor_id = $this->doctor_model->update_data($doctor_id);
            if ($doctor_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "doctors/edit/$doctor_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "doctors/edit/$doctor_id");
            }
        } else {
            $this->edit($doctor_id);
        }
    }


    /**
     * function to move a record up in list
     * @param $doctor_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($doctor_id, $page_id = NULL)
    {

        $doctor_id = (int) $doctor_id;

        //get order number of this record
        $this_doctor_where = "doctor_id = $doctor_id";
        $this_doctor = $this->doctor_model->getBy($this_doctor_where, true);
        $this_doctor_id = $doctor_id;
        $this_doctor_order = $this_doctor->order;


        //get order number of previous record
        $previous_doctor_where = "order <= $this_doctor_order AND doctor_id != $doctor_id ORDER BY `order` DESC";
        $previous_doctor = $this->doctor_model->getBy($previous_doctor_where, true);
        $previous_doctor_id = $previous_doctor->doctor_id;
        $previous_doctor_order = $previous_doctor->order;

        //if this is the first element
        if (!$previous_doctor_id) {
            redirect(ADMIN_DIR . "doctors/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_doctor_inputs = array(
            "order" => $previous_doctor_order
        );
        $this->doctor_model->save($this_doctor_inputs, $this_doctor_id);

        $previous_doctor_inputs = array(
            "order" => $this_doctor_order
        );
        $this->doctor_model->save($previous_doctor_inputs, $previous_doctor_id);



        redirect(ADMIN_DIR . "doctors/view/" . $page_id);
    }
    //-------------------------------------------------------------------------------------

    /**
     * function to move a record up in list
     * @param $doctor_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($doctor_id, $page_id = NULL)
    {

        $doctor_id = (int) $doctor_id;



        //get order number of this record
        $this_doctor_where = "doctor_id = $doctor_id";
        $this_doctor = $this->doctor_model->getBy($this_doctor_where, true);
        $this_doctor_id = $doctor_id;
        $this_doctor_order = $this_doctor->order;


        //get order number of next record

        $next_doctor_where = "order >= $this_doctor_order and doctor_id != $doctor_id ORDER BY `order` ASC";
        $next_doctor = $this->doctor_model->getBy($next_doctor_where, true);
        $next_doctor_id = $next_doctor->doctor_id;
        $next_doctor_order = $next_doctor->order;

        //if this is the first element
        if (!$next_doctor_id) {
            redirect(ADMIN_DIR . "doctors/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_doctor_inputs = array(
            "order" => $next_doctor_order
        );
        $this->doctor_model->save($this_doctor_inputs, $this_doctor_id);

        $next_doctor_inputs = array(
            "order" => $this_doctor_order
        );
        $this->doctor_model->save($next_doctor_inputs, $next_doctor_id);



        redirect(ADMIN_DIR . "doctors/view/" . $page_id);
    }

    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["doctors"] = $this->doctor_model->getBy($where, false, "doctor_id");
        $j_array[] = array("id" => "", "value" => "doctor");
        foreach ($data["doctors"] as $doctor) {
            $j_array[] = array("id" => $doctor->doctor_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
