<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class System_global_settings extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/system_global_setting_model");
        $this->lang->load("system_global_settings", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {
        $main_page = base_url() . ADMIN_DIR . $this->router->fetch_class() . "/view_system_global_setting/1";
        redirect($main_page);
    }
    //---------------------------------------------------------------



    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {
        $main_page = base_url() . ADMIN_DIR . $this->router->fetch_class() . "/view_system_global_setting/1";
        redirect($main_page);
        $where = "";
        $data = $this->system_global_setting_model->get_system_global_setting_list($where);
        $this->data["system_global_settings"] = $data->system_global_settings;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('System Global Settings');
        $this->data["view"] = ADMIN_DIR . "system_global_settings/system_global_settings";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_system_global_setting($system_global_setting_id)
    {

        $system_global_setting_id = (int) $system_global_setting_id;

        $this->data["system_global_settings"] = $this->system_global_setting_model->get_system_global_setting($system_global_setting_id);
        $this->data["title"] = $this->lang->line('System Global Setting Details');
        $this->data["view"] = ADMIN_DIR . "system_global_settings/view_system_global_setting";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "";
        $data = $this->system_global_setting_model->get_system_global_setting_list($where);
        $this->data["system_global_settings"] = $data->system_global_settings;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed System Global Settings');
        $this->data["view"] = ADMIN_DIR . "system_global_settings/trashed_system_global_settings";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($system_global_setting_id, $page_id = NULL)
    {

        $system_global_setting_id = (int) $system_global_setting_id;


        $this->system_global_setting_model->changeStatus($system_global_setting_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "system_global_settings/view/" . $page_id);
    }

    /**
     * function to restor system_global_setting from trash
     * @param $system_global_setting_id integer
     */
    public function restore($system_global_setting_id, $page_id = NULL)
    {

        $system_global_setting_id = (int) $system_global_setting_id;


        $this->system_global_setting_model->changeStatus($system_global_setting_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "system_global_settings/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft system_global_setting from trash
     * @param $system_global_setting_id integer
     */
    public function draft($system_global_setting_id, $page_id = NULL)
    {

        $system_global_setting_id = (int) $system_global_setting_id;


        $this->system_global_setting_model->changeStatus($system_global_setting_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "system_global_settings/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish system_global_setting from trash
     * @param $system_global_setting_id integer
     */
    public function publish($system_global_setting_id, $page_id = NULL)
    {

        $system_global_setting_id = (int) $system_global_setting_id;


        $this->system_global_setting_model->changeStatus($system_global_setting_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "system_global_settings/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a System_global_setting
     * @param $system_global_setting_id integer
     */
    public function delete($system_global_setting_id, $page_id = NULL)
    {

        $system_global_setting_id = (int) $system_global_setting_id;
        $this->system_global_setting_model->changeStatus($system_global_setting_id, "3");
        //Remove file....
        //			$system_global_settings = $this->system_global_setting_model->get_system_global_setting($system_global_setting_id);
        //			$file_path = $system_global_settings[0]->sytem_admin_logo;
        //			$this->system_global_setting_model->delete_file($file_path);
        //$this->system_global_setting_model->delete(array( 'system_global_setting_id' => $system_global_setting_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "system_global_settings/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new System_global_setting
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New System Global Setting');
        $this->data["view"] = ADMIN_DIR . "system_global_settings/add_system_global_setting";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->system_global_setting_model->validate_form_data() === TRUE) {

            if ($this->upload_file("sytem_public_logo")) {
                $_POST['sytem_public_logo'] = $this->data["upload_data"]["file_name"];
            }

            if ($this->upload_file("sytem_admin_logo")) {
                $_POST['sytem_admin_logo'] = $this->data["upload_data"]["file_name"];
            }

            $system_global_setting_id = $this->system_global_setting_model->save_data();
            if ($system_global_setting_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "system_global_settings/edit/$system_global_setting_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "system_global_settings/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a System_global_setting
     */
    public function edit($system_global_setting_id)
    {
        $system_global_setting_id = (int) $system_global_setting_id;
        $this->data["system_global_setting"] = $this->system_global_setting_model->get($system_global_setting_id);

        $this->data["title"] = $this->lang->line('Edit System Global Setting');
        $this->data["view"] = ADMIN_DIR . "system_global_settings/edit_system_global_setting";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($system_global_setting_id)
    {

        $system_global_setting_id = (int) $system_global_setting_id;

        if ($this->system_global_setting_model->validate_form_data() === TRUE) {

            if ($this->upload_file("sytem_public_logo")) {
                $_POST["sytem_public_logo"] = $this->data["upload_data"]["file_name"];
            }

            if ($this->upload_file("sytem_admin_logo")) {
                $_POST["sytem_admin_logo"] = $this->data["upload_data"]["file_name"];
            }

            $system_global_setting_id = $this->system_global_setting_model->update_data($system_global_setting_id);
            if ($system_global_setting_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "system_global_settings/edit/$system_global_setting_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "system_global_settings/edit/$system_global_setting_id");
            }
        } else {
            $this->edit($system_global_setting_id);
        }
    }


    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["system_global_settings"] = $this->system_global_setting_model->getBy($where, false, "system_global_setting_id");
        $j_array[] = array("id" => "", "value" => "system_global_setting");
        foreach ($data["system_global_settings"] as $system_global_setting) {
            $j_array[] = array("id" => $system_global_setting->system_global_setting_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
