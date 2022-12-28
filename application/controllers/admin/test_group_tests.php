<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test_group_tests extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/test_group_test_model");

        $this->lang->load("test_group_tests", 'english');
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

        $where = "ORDER BY `test_group_tests`.`order`";
        $where = NULL;
        $data = $this->test_group_test_model->get_test_group_test_list($where);
        $this->data["test_group_tests"] = $data->test_group_tests;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Test Group Tests');
        $this->data["view"] = ADMIN_DIR . "test_group_tests/test_group_tests";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_test_group_test($test_group_test_id)
    {

        $test_group_test_id = (int) $test_group_test_id;

        $this->data["test_group_tests"] = $this->test_group_test_model->get_test_group_test($test_group_test_id);
        $this->data["title"] = $this->lang->line('Test Group Test Details');
        $this->data["view"] = ADMIN_DIR . "test_group_tests/view_test_group_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "ORDER BY `test_group_tests`.`order`";
        $data = $this->test_group_test_model->get_test_group_test_list($where);
        $this->data["test_group_tests"] = $data->test_group_tests;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Test Group Tests');
        $this->data["view"] = ADMIN_DIR . "test_group_tests/trashed_test_group_tests";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($test_group_test_id, $page_id = NULL)
    {

        $test_group_test_id = (int) $test_group_test_id;


        $this->test_group_test_model->changeStatus($test_group_test_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "test_group_tests/view/" . $page_id);
    }

    /**
     * function to restor test_group_test from trash
     * @param $test_group_test_id integer
     */
    public function restore($test_group_test_id, $page_id = NULL)
    {

        $test_group_test_id = (int) $test_group_test_id;


        $this->test_group_test_model->changeStatus($test_group_test_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "test_group_tests/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft test_group_test from trash
     * @param $test_group_test_id integer
     */
    public function draft($test_group_test_id, $page_id = NULL)
    {

        $test_group_test_id = (int) $test_group_test_id;


        $this->test_group_test_model->changeStatus($test_group_test_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "test_group_tests/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish test_group_test from trash
     * @param $test_group_test_id integer
     */
    public function publish($test_group_test_id, $page_id = NULL)
    {

        $test_group_test_id = (int) $test_group_test_id;


        $this->test_group_test_model->changeStatus($test_group_test_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "test_group_tests/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Test_group_test
     * @param $test_group_test_id integer
     */
    public function delete($test_group_test_id, $page_id = NULL)
    {

        $test_group_test_id = (int) $test_group_test_id;
        //$this->test_group_test_model->changeStatus($test_group_test_id, "3");

        $this->test_group_test_model->delete(array('test_group_test_id' => $test_group_test_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "test_group_tests/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Test_group_test
     */
    public function add()
    {



        $where = "`test_types`.`status` IN (1) ORDER BY `test_types`.`order`";
        $data = $this->test_type_model->get_test_type_list($where);





        $this->data["tests"] = $this->test_group_test_model->getList("tests", "test_id", "test_name", $where = "`tests`.`status` IN (1) ");

        $this->data["title"] = $this->lang->line('Add New Test Group Test');
        $this->data["view"] = ADMIN_DIR . "test_group_tests/add_test_group_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->test_group_test_model->validate_form_data() === TRUE) {

            $test_group_test_id = $this->test_group_test_model->save_data();
            if ($test_group_test_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "test_group_tests/edit/$test_group_test_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "test_group_tests/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Test_group_test
     */
    public function edit($test_group_test_id)
    {
        $test_group_test_id = (int) $test_group_test_id;
        $this->data["test_group_test"] = $this->test_group_test_model->get($test_group_test_id);

        $this->data["tests"] = $this->test_group_test_model->getList("tests", "test_id", "test_name", $where = "`tests`.`status` IN (1) ");

        $this->data["title"] = $this->lang->line('Edit Test Group Test');
        $this->data["view"] = ADMIN_DIR . "test_group_tests/edit_test_group_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($test_group_test_id)
    {

        $test_group_test_id = (int) $test_group_test_id;

        if ($this->test_group_test_model->validate_form_data() === TRUE) {

            $test_group_test_id = $this->test_group_test_model->update_data($test_group_test_id);
            if ($test_group_test_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "test_group_tests/edit/$test_group_test_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "test_group_tests/edit/$test_group_test_id");
            }
        } else {
            $this->edit($test_group_test_id);
        }
    }


    /**
     * function to move a record up in list
     * @param $test_group_test_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($test_group_test_id, $page_id = NULL)
    {

        $test_group_test_id = (int) $test_group_test_id;

        //get order number of this record
        $this_test_group_test_where = "test_group_test_id = $test_group_test_id";
        $this_test_group_test = $this->test_group_test_model->getBy($this_test_group_test_where, true);
        $this_test_group_test_id = $test_group_test_id;
        $this_test_group_test_order = $this_test_group_test->order;


        //get order number of previous record
        $previous_test_group_test_where = "order <= $this_test_group_test_order AND test_group_test_id != $test_group_test_id ORDER BY `order` DESC";
        $previous_test_group_test = $this->test_group_test_model->getBy($previous_test_group_test_where, true);
        $previous_test_group_test_id = $previous_test_group_test->test_group_test_id;
        $previous_test_group_test_order = $previous_test_group_test->order;

        //if this is the first element
        if (!$previous_test_group_test_id) {
            redirect(ADMIN_DIR . "test_group_tests/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_test_group_test_inputs = array(
            "order" => $previous_test_group_test_order
        );
        $this->test_group_test_model->save($this_test_group_test_inputs, $this_test_group_test_id);

        $previous_test_group_test_inputs = array(
            "order" => $this_test_group_test_order
        );
        $this->test_group_test_model->save($previous_test_group_test_inputs, $previous_test_group_test_id);



        redirect(ADMIN_DIR . "test_group_tests/view/" . $page_id);
    }
    //-------------------------------------------------------------------------------------

    /**
     * function to move a record up in list
     * @param $test_group_test_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($test_group_test_id, $page_id = NULL)
    {

        $test_group_test_id = (int) $test_group_test_id;



        //get order number of this record
        $this_test_group_test_where = "test_group_test_id = $test_group_test_id";
        $this_test_group_test = $this->test_group_test_model->getBy($this_test_group_test_where, true);
        $this_test_group_test_id = $test_group_test_id;
        $this_test_group_test_order = $this_test_group_test->order;


        //get order number of next record

        $next_test_group_test_where = "order >= $this_test_group_test_order and test_group_test_id != $test_group_test_id ORDER BY `order` ASC";
        $next_test_group_test = $this->test_group_test_model->getBy($next_test_group_test_where, true);
        $next_test_group_test_id = $next_test_group_test->test_group_test_id;
        $next_test_group_test_order = $next_test_group_test->order;

        //if this is the first element
        if (!$next_test_group_test_id) {
            redirect(ADMIN_DIR . "test_group_tests/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_test_group_test_inputs = array(
            "order" => $next_test_group_test_order
        );
        $this->test_group_test_model->save($this_test_group_test_inputs, $this_test_group_test_id);

        $next_test_group_test_inputs = array(
            "order" => $this_test_group_test_order
        );
        $this->test_group_test_model->save($next_test_group_test_inputs, $next_test_group_test_id);



        redirect(ADMIN_DIR . "test_group_tests/view/" . $page_id);
    }

    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["test_group_tests"] = $this->test_group_test_model->getBy($where, false, "test_group_test_id");
        $j_array[] = array("id" => "", "value" => "test_group_test");
        foreach ($data["test_group_tests"] as $test_group_test) {
            $j_array[] = array("id" => $test_group_test->test_group_test_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
