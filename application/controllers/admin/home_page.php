<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_page extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/home_page_model");
        $this->lang->load("home_page", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {
        $main_page = base_url() . ADMIN_DIR . $this->router->fetch_class() . "/view_home_page/1";
        redirect($main_page);
    }
    //---------------------------------------------------------------



    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {
        $main_page = base_url() . ADMIN_DIR . $this->router->fetch_class() . "/view_home_page/1";
        redirect($main_page);
        $where = "";
        $data = $this->home_page_model->get_home_page_list($where);
        $this->data["home_page"] = $data->home_page;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Home Page');
        $this->data["view"] = ADMIN_DIR . "home_page/home_page";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_home_page($home_page_id)
    {

        $home_page_id = (int) $home_page_id;
        //set home page metatags
        /*$this->data['page_description']; 
		$this->data['title'];*/

        $this->data["home_page"] = $this->home_page_model->get_home_page($home_page_id);
        $this->data["title"] = $this->lang->line('Home Page Details');
        $this->data["view"] = ADMIN_DIR . "home_page/view_home_page";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "";
        $data = $this->home_page_model->get_home_page_list($where);
        $this->data["home_page"] = $data->home_page;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Home Page');
        $this->data["view"] = ADMIN_DIR . "home_page/trashed_home_page";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($home_page_id, $page_id = NULL)
    {

        $home_page_id = (int) $home_page_id;


        $this->home_page_model->changeStatus($home_page_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "home_page/view/" . $page_id);
    }

    /**
     * function to restor home_page from trash
     * @param $home_page_id integer
     */
    public function restore($home_page_id, $page_id = NULL)
    {

        $home_page_id = (int) $home_page_id;


        $this->home_page_model->changeStatus($home_page_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "home_page/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft home_page from trash
     * @param $home_page_id integer
     */
    public function draft($home_page_id, $page_id = NULL)
    {

        $home_page_id = (int) $home_page_id;


        $this->home_page_model->changeStatus($home_page_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "home_page/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish home_page from trash
     * @param $home_page_id integer
     */
    public function publish($home_page_id, $page_id = NULL)
    {

        $home_page_id = (int) $home_page_id;


        $this->home_page_model->changeStatus($home_page_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "home_page/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Home_page
     * @param $home_page_id integer
     */
    public function delete($home_page_id, $page_id = NULL)
    {

        $home_page_id = (int) $home_page_id;
        //$this->home_page_model->changeStatus($home_page_id, "3");

        //$this->home_page_model->delete(array( 'home_page_id' => $home_page_id));
        //$this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "home_page/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Home_page
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Home Page');
        $this->data["view"] = ADMIN_DIR . "home_page/add_home_page";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->home_page_model->validate_form_data() === TRUE) {

            $home_page_id = $this->home_page_model->save_data();
            if ($home_page_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "home_page/edit/$home_page_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "home_page/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Home_page
     */
    public function edit($home_page_id)
    {
        $home_page_id = (int) $home_page_id;
        $this->data["home_page"] = $this->home_page_model->get($home_page_id);

        $this->data["title"] = $this->lang->line('Edit Home Page');
        $this->data["view"] = ADMIN_DIR . "home_page/edit_home_page";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($home_page_id)
    {

        $home_page_id = (int) $home_page_id;

        if ($this->home_page_model->validate_form_data() === TRUE) {

            $home_page_id = $this->home_page_model->update_data($home_page_id);
            if ($home_page_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "home_page/edit/$home_page_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "home_page/edit/$home_page_id");
            }
        } else {
            $this->edit($home_page_id);
        }
    }


    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["home_page"] = $this->home_page_model->getBy($where, false, "home_page_id");
        $j_array[] = array("id" => "", "value" => "home_page");
        foreach ($data["home_page"] as $home_page) {
            $j_array[] = array("id" => $home_page->home_page_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
