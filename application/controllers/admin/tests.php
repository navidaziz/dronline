<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tests extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/test_model");
        $this->lang->load("tests", 'english');
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

        $where = "`tests`.`status` IN (0, 1) ORDER BY `tests`.`order`";
        $this->data["tests"] = $this->test_model->get_test_list($where, false);
        //$this->data["tests"] = $data->tests;
        //$this->data["pagination"] = $data->pagination;
        $this->data["pagination"] = false;
        $this->data["title"] = $this->lang->line('Tests');
        $this->data["view"] = ADMIN_DIR . "tests/tests";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_test($test_id)
    {

        $test_id = (int) $test_id;

        $this->data["tests"] = $this->test_model->get_test($test_id);
        $this->data["title"] = $this->lang->line('Test Details');
        $this->data["view"] = ADMIN_DIR . "tests/view_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`tests`.`status` IN (2) ORDER BY `tests`.`order`";
        $data = $this->test_model->get_test_list($where);
        $this->data["tests"] = $data->tests;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Tests');
        $this->data["view"] = ADMIN_DIR . "tests/trashed_tests";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;


        $this->test_model->changeStatus($test_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "tests/view/" . $page_id);
    }

    /**
     * function to restor test from trash
     * @param $test_id integer
     */
    public function restore($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;


        $this->test_model->changeStatus($test_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "tests/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft test from trash
     * @param $test_id integer
     */
    public function draft($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;


        $this->test_model->changeStatus($test_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "tests/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish test from trash
     * @param $test_id integer
     */
    public function publish($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;


        $this->test_model->changeStatus($test_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "tests/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Test
     * @param $test_id integer
     */
    public function delete($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;
        $this->test_model->changeStatus($test_id, "3");

        //$this->test_model->delete(array('test_id' => $test_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "tests/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Test
     */
    public function add()
    {

        $this->data["test_categories"] = $this->test_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) ");

        $this->data["test_types"] = $this->test_model->getList("test_types", "test_type_id", "test_type", $where = "`test_types`.`status` IN (1) ");

        $this->data["title"] = $this->lang->line('Add New Test');
        $this->data["view"] = ADMIN_DIR . "tests/add_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->test_model->validate_form_data() === TRUE) {

            $test_id = $this->test_model->save_data();
            if ($test_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "tests/edit/$test_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "tests/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Test
     */
    public function edit($test_id)
    {
        $test_id = (int) $test_id;
        $this->data["test"] = $this->test_model->get($test_id);

        $this->data["test_categories"] = $this->test_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) ");

        $this->data["test_types"] = $this->test_model->getList("test_types", "test_type_id", "test_type", $where = "`test_types`.`status` IN (1) ");

        $this->data["title"] = $this->lang->line('Edit Test');
        $this->data["view"] = ADMIN_DIR . "tests/edit_test";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($test_id)
    {

        $test_id = (int) $test_id;

        if ($this->test_model->validate_form_data() === TRUE) {

            $test_id = $this->test_model->update_data($test_id);
            if ($test_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "tests/edit/$test_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "tests/edit/$test_id");
            }
        } else {
            $this->edit($test_id);
        }
    }


    /**
     * function to move a record up in list
     * @param $test_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;

        //get order number of this record
        $this_test_where = "test_id = $test_id";
        $this_test = $this->test_model->getBy($this_test_where, true);
        $this_test_id = $test_id;
        $this_test_order = $this_test->order;


        //get order number of previous record
        $previous_test_where = "order <= $this_test_order AND test_id != $test_id ORDER BY `order` DESC";
        $previous_test = $this->test_model->getBy($previous_test_where, true);
        $previous_test_id = $previous_test->test_id;
        $previous_test_order = $previous_test->order;

        //if this is the first element
        if (!$previous_test_id) {
            redirect(ADMIN_DIR . "tests/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_test_inputs = array(
            "order" => $previous_test_order
        );
        $this->test_model->save($this_test_inputs, $this_test_id);

        $previous_test_inputs = array(
            "order" => $this_test_order
        );
        $this->test_model->save($previous_test_inputs, $previous_test_id);



        redirect(ADMIN_DIR . "tests/view/" . $page_id);
    }
    //-------------------------------------------------------------------------------------

    /**
     * function to move a record up in list
     * @param $test_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($test_id, $page_id = NULL)
    {

        $test_id = (int) $test_id;



        //get order number of this record
        $this_test_where = "test_id = $test_id";
        $this_test = $this->test_model->getBy($this_test_where, true);
        $this_test_id = $test_id;
        $this_test_order = $this_test->order;


        //get order number of next record

        $next_test_where = "order >= $this_test_order and test_id != $test_id ORDER BY `order` ASC";
        $next_test = $this->test_model->getBy($next_test_where, true);
        $next_test_id = $next_test->test_id;
        $next_test_order = $next_test->order;

        //if this is the first element
        if (!$next_test_id) {
            redirect(ADMIN_DIR . "tests/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_test_inputs = array(
            "order" => $next_test_order
        );
        $this->test_model->save($this_test_inputs, $this_test_id);

        $next_test_inputs = array(
            "order" => $this_test_order
        );
        $this->test_model->save($next_test_inputs, $next_test_id);



        redirect(ADMIN_DIR . "tests/view/" . $page_id);
    }

    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["tests"] = $this->test_model->getBy($where, false, "test_id");
        $j_array[] = array("id" => "", "value" => "test");
        foreach ($data["tests"] as $test) {
            $j_array[] = array("id" => $test->test_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
