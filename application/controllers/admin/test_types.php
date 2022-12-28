<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test_types extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/test_type_model");
        $this->lang->load("test_types", 'english');
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

        $where = "`test_types`.`status` IN (0, 1) ORDER BY `test_types`.`order`";
        $data = $this->test_type_model->get_test_type_list($where);
        $this->data["test_types"] = $data->test_types;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Test Types');
        $this->data["view"] = ADMIN_DIR . "test_types/test_types";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_test_type($test_type_id)
    {

        $test_type_id = (int) $test_type_id;

        $this->data["test_types"] = $this->test_type_model->get_test_type($test_type_id);
        $this->data["title"] = $this->lang->line('Test Type Details');
        $this->data["view"] = ADMIN_DIR . "test_types/view_test_type";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`test_types`.`status` IN (2) ORDER BY `test_types`.`order`";
        $data = $this->test_type_model->get_test_type_list($where);
        $this->data["test_types"] = $data->test_types;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Test Types');
        $this->data["view"] = ADMIN_DIR . "test_types/trashed_test_types";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($test_type_id, $page_id = NULL)
    {

        $test_type_id = (int) $test_type_id;


        $this->test_type_model->changeStatus($test_type_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "test_types/view/" . $page_id);
    }

    /**
     * function to restor test_type from trash
     * @param $test_type_id integer
     */
    public function restore($test_type_id, $page_id = NULL)
    {

        $test_type_id = (int) $test_type_id;


        $this->test_type_model->changeStatus($test_type_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "test_types/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft test_type from trash
     * @param $test_type_id integer
     */
    public function draft($test_type_id, $page_id = NULL)
    {

        $test_type_id = (int) $test_type_id;


        $this->test_type_model->changeStatus($test_type_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "test_types/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish test_type from trash
     * @param $test_type_id integer
     */
    public function publish($test_type_id, $page_id = NULL)
    {

        $test_type_id = (int) $test_type_id;


        $this->test_type_model->changeStatus($test_type_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "test_types/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Test_type
     * @param $test_type_id integer
     */
    public function delete($test_type_id, $page_id = NULL)
    {

        $test_type_id = (int) $test_type_id;
        $this->test_type_model->changeStatus($test_type_id, "3");
        //Remove file....
        //		$test_types = $this->test_type_model->get_test_type($test_type_id);
        //		$file_path = $test_types[0]->image;
        //		$this->test_type_model->delete_file($file_path);
        //$this->test_type_model->delete(array( 'test_type_id' => $test_type_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "test_types/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Test_type
     */
    public function add()
    {

        $this->data["test_categories"] = $this->test_type_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) ");

        $this->data["title"] = $this->lang->line('Add New Test Type');
        $this->data["view"] = ADMIN_DIR . "test_types/add_test_type";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->test_type_model->validate_form_data() === TRUE) {

            if ($this->upload_file("image")) {
                $_POST['image'] = $this->data["upload_data"]["file_name"];
            }

            $test_type_id = $this->test_type_model->save_data();
            if ($test_type_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "test_types/edit/$test_type_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "test_types/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Test_type
     */
    public function edit($test_type_id)
    {
        $test_type_id = (int) $test_type_id;
        $this->data["test_type"] = $this->test_type_model->get($test_type_id);

        $this->data["test_categories"] = $this->test_type_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) ");

        $this->data["title"] = $this->lang->line('Edit Test Type');
        $this->data["view"] = ADMIN_DIR . "test_types/edit_test_type";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($test_type_id)
    {

        $test_type_id = (int) $test_type_id;

        if ($this->test_type_model->validate_form_data() === TRUE) {

            if ($this->upload_file("image")) {
                $_POST["image"] = $this->data["upload_data"]["file_name"];
            }

            $test_type_id = $this->test_type_model->update_data($test_type_id);
            if ($test_type_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "test_types/edit/$test_type_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "test_types/edit/$test_type_id");
            }
        } else {
            $this->edit($test_type_id);
        }
    }


    /**
     * function to move a record up in list
     * @param $test_type_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($test_type_id, $page_id = NULL)
    {

        $test_type_id = (int) $test_type_id;

        //get order number of this record
        $this_test_type_where = "test_type_id = $test_type_id";
        $this_test_type = $this->test_type_model->getBy($this_test_type_where, true);
        $this_test_type_id = $test_type_id;
        $this_test_type_order = $this_test_type->order;


        //get order number of previous record
        $previous_test_type_where = "order <= $this_test_type_order AND test_type_id != $test_type_id ORDER BY `order` DESC";
        $previous_test_type = $this->test_type_model->getBy($previous_test_type_where, true);
        $previous_test_type_id = $previous_test_type->test_type_id;
        $previous_test_type_order = $previous_test_type->order;

        //if this is the first element
        if (!$previous_test_type_id) {
            redirect(ADMIN_DIR . "test_types/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_test_type_inputs = array(
            "order" => $previous_test_type_order
        );
        $this->test_type_model->save($this_test_type_inputs, $this_test_type_id);

        $previous_test_type_inputs = array(
            "order" => $this_test_type_order
        );
        $this->test_type_model->save($previous_test_type_inputs, $previous_test_type_id);



        redirect(ADMIN_DIR . "test_types/view/" . $page_id);
    }
    //-------------------------------------------------------------------------------------

    /**
     * function to move a record up in list
     * @param $test_type_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($test_type_id, $page_id = NULL)
    {

        $test_type_id = (int) $test_type_id;



        //get order number of this record
        $this_test_type_where = "test_type_id = $test_type_id";
        $this_test_type = $this->test_type_model->getBy($this_test_type_where, true);
        $this_test_type_id = $test_type_id;
        $this_test_type_order = $this_test_type->order;


        //get order number of next record

        $next_test_type_where = "order >= $this_test_type_order and test_type_id != $test_type_id ORDER BY `order` ASC";
        $next_test_type = $this->test_type_model->getBy($next_test_type_where, true);
        $next_test_type_id = $next_test_type->test_type_id;
        $next_test_type_order = $next_test_type->order;

        //if this is the first element
        if (!$next_test_type_id) {
            redirect(ADMIN_DIR . "test_types/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_test_type_inputs = array(
            "order" => $next_test_type_order
        );
        $this->test_type_model->save($this_test_type_inputs, $this_test_type_id);

        $next_test_type_inputs = array(
            "order" => $this_test_type_order
        );
        $this->test_type_model->save($next_test_type_inputs, $next_test_type_id);



        redirect(ADMIN_DIR . "test_types/view/" . $page_id);
    }

    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["test_types"] = $this->test_type_model->getBy($where, false, "test_type_id");
        $j_array[] = array("id" => "", "value" => "test_type");
        foreach ($data["test_types"] as $test_type) {
            $j_array[] = array("id" => $test_type->test_type_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
