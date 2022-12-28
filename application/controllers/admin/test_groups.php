<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test_groups extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/test_group_model");
        $this->load->model("admin/test_type_model");

        $this->load->model("admin/test_model");
        $this->lang->load("tests", 'english');
        $this->lang->load("system", 'english');
        $this->load->model("admin/test_group_test_model");
        $this->lang->load("test_group_tests", 'english');
        $this->lang->load("test_groups", 'english');
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

    public function update_test_group_order()
    {
        $test_group_id = (int) $this->input->post("test_group_id");
        $test_order =  (int) $this->input->post("test_order");

        $query = "UPDATE test_groups SET `order` ='" . $test_order . "'
        WHERE test_group_id = '" . $test_group_id . "'";
        if ($this->db->query($query)) {

            echo $test_order;
        }
    }


    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {

        $where = "`test_groups`.`status` IN (0, 1) ORDER BY `test_groups`.`order`";
        $this->data["test_groups"] = $this->test_group_model->get_test_group_list($where, false);
        // $this->data["test_groups"] = $data->test_groups;
        //$this->data["pagination"] = $data->pagination;
        $this->data["pagination"] = '';
        $this->data["title"] = "Services";
        $this->data["view"] = ADMIN_DIR . "test_groups/test_groups";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }


    public function view2()
    {

        $where = "`test_groups`.`status` IN (0, 1) ORDER BY `test_groups`.`order`";
        $this->data["test_groups"] = $this->test_group_model->get_test_group_list($where, false);
        // $this->data["test_groups"] = $data->test_groups;
        //$this->data["pagination"] = $data->pagination;
        $this->data["pagination"] = '';
        $this->data["title"] = "Services";
        $this->data["view"] = ADMIN_DIR . "test_groups/test_group_tests";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_test_group($test_group_id)
    {

        $test_group_id = (int) $test_group_id;


        $query = "SELECT `test_id` FROM `test_group_tests` 
			WHERE `test_group_id`='" . $test_group_id . "'";
        $query_result = $this->db->query($query);
        $group_tests = $query_result->result();
        $group_test_ids = '0';
        foreach ($group_tests as $group_test) {
            $group_test_ids .= ' ,' . $group_test->test_id;
        }

        $this->data["test_categories"] = $this->test_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) LIMIT 1 ");

        $this->data["test_types_list"] = $this->test_model->getList("test_types", "test_type_id", "test_type", $where = "`test_types`.`status` IN (1) ");



        //$where = "`test_group_tests`.`test_group_id` ='".$test_group_id."' ORDER BY `test_group_tests`.`order`";
        //$this->data["test_group_tests"] = $this->test_group_test_model->get_test_group_test_list($where, false);



        $query = "SELECT `test_types`.`test_type`, `test_types`.`test_type_id` 
            FROM
            `tests`, `test_group_tests`, `test_types`  
            WHERE `tests`.`test_id` = `test_group_tests`.`test_id`
            AND `test_group_tests`.`test_group_id` ='" . $test_group_id . "' 
            AND `test_types`.`test_type_id` = `tests`.`test_type_id`
            GROUP BY `test_types`.`test_type_id` 
            ";

        $test_group_types = $this->db->query($query)->result();
        foreach ($test_group_types as $test_group_type) {
            $query = "SELECT
                `test_group_tests`.`test_group_id`
                , `test_group_tests`.`test_id`
                , `tests`.`test_name`
                , `tests`.`test_time`
                , `tests`.`unit`
                , `tests`.`result_suffix`
                , `tests`.`test_price`
                , `tests`.`test_description`
                , `tests`.`normal_values`
                , `test_group_tests`.`test_group_test_id`
                , `test_types`.`test_type` 
            FROM
            `tests`, `test_group_tests`, `test_types`  
            WHERE `tests`.`test_id` = `test_group_tests`.`test_id`
            AND `test_types`.`test_type_id` = `tests`.`test_type_id`
            AND `test_group_tests`.`test_group_id` ='" . $test_group_id . "' 
            AND `tests`.`test_type_id` ='" . $test_group_type->test_type_id . "'
            ORDER BY `test_group_tests`.`order`
            ";

            $test_group_type->test_group_tests = $this->db->query($query)->result();
        }



        $this->data["test_group_types"] =  $test_group_types;



        $where = "`test_types`.`status` IN (1)  ORDER BY `test_types`.`order`";
        $test_types = $this->test_type_model->get_test_type_list($where, false);
        foreach ($test_types as $test_type) {
            $test_type->tests =  $this->test_group_test_model->getList("tests", "test_id", "test_name", $where = "`tests`.`status` IN (1) AND `test_type_id`='" . $test_type->test_type_id . "' AND `test_id` NOT IN (" . $group_test_ids . ")");
        }
        $this->data["test_types"] =  $test_types;



        $this->data["test_groups"] = $this->test_group_model->get_test_group($test_group_id);
        $this->data["title"] = $this->lang->line('Test Group Details');
        $this->data["view"] = ADMIN_DIR . "test_groups/view_test_group";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`test_groups`.`status` IN (2) ORDER BY `test_groups`.`order`";
        $data = $this->test_group_model->get_test_group_list($where);
        $this->data["test_groups"] = $data->test_groups;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Test Groups');
        $this->data["view"] = ADMIN_DIR . "test_groups/trashed_test_groups";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($test_group_id, $page_id = NULL)
    {

        $test_group_id = (int) $test_group_id;


        $this->test_group_model->changeStatus($test_group_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "test_groups/view/" . $page_id);
    }

    /**
     * function to restor test_group from trash
     * @param $test_group_id integer
     */
    public function restore($test_group_id, $page_id = NULL)
    {

        $test_group_id = (int) $test_group_id;


        $this->test_group_model->changeStatus($test_group_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "test_groups/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft test_group from trash
     * @param $test_group_id integer
     */
    public function draft($test_group_id, $page_id = NULL)
    {

        $test_group_id = (int) $test_group_id;


        $this->test_group_model->changeStatus($test_group_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "test_groups/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish test_group from trash
     * @param $test_group_id integer
     */
    public function publish($test_group_id, $page_id = NULL)
    {

        $test_group_id = (int) $test_group_id;


        $this->test_group_model->changeStatus($test_group_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "test_groups/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Test_group
     * @param $test_group_id integer
     */
    public function delete($test_group_id, $page_id = NULL)
    {

        $test_group_id = (int) $test_group_id;
        //$this->test_group_model->changeStatus($test_group_id, "3");

        $this->test_group_model->delete(array('test_group_id' => $test_group_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "test_groups/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Test_group
     */
    public function add()
    {
        $this->data["test_categories"] = $this->test_type_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) ");


        $this->data["title"] = 'Add New Service';
        $this->data["view"] = ADMIN_DIR . "test_groups/add_test_group";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->test_group_model->validate_form_data() === TRUE) {

            $test_group_id = $this->test_group_model->save_data();
            if ($test_group_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "test_groups/edit/$test_group_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "test_groups/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Test_group
     */
    public function edit($test_group_id)
    {

        $this->data["test_categories"] = $this->test_type_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) ");

        $test_group_id = (int) $test_group_id;
        $this->data["test_group"] = $this->test_group_model->get($test_group_id);

        $this->data["title"] = 'Edit Test Group';
        $this->data["view"] = ADMIN_DIR . "test_groups/edit_test_group";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($test_group_id)
    {

        $test_group_id = (int) $test_group_id;

        if ($this->test_group_model->validate_form_data() === TRUE) {

            $test_group_id = $this->test_group_model->update_data($test_group_id);
            if ($test_group_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "test_groups/edit/$test_group_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "test_groups/edit/$test_group_id");
            }
        } else {
            $this->edit($test_group_id);
        }
    }


    /**
     * function to move a record up in list
     * @param $test_group_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($test_group_id, $page_id = NULL)
    {

        $test_group_id = (int) $test_group_id;

        //get order number of this record
        $this_test_group_where = "test_group_id = $test_group_id";
        $this_test_group = $this->test_group_model->getBy($this_test_group_where, true);
        $this_test_group_id = $test_group_id;
        $this_test_group_order = $this_test_group->order;


        //get order number of previous record
        $previous_test_group_where = "order <= $this_test_group_order AND test_group_id != $test_group_id ORDER BY `order` DESC";
        $previous_test_group = $this->test_group_model->getBy($previous_test_group_where, true);
        $previous_test_group_id = $previous_test_group->test_group_id;
        $previous_test_group_order = $previous_test_group->order;

        //if this is the first element
        if (!$previous_test_group_id) {
            redirect(ADMIN_DIR . "test_groups/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_test_group_inputs = array(
            "order" => $previous_test_group_order
        );
        $this->test_group_model->save($this_test_group_inputs, $this_test_group_id);

        $previous_test_group_inputs = array(
            "order" => $this_test_group_order
        );
        $this->test_group_model->save($previous_test_group_inputs, $previous_test_group_id);



        redirect(ADMIN_DIR . "test_groups/view/" . $page_id);
    }
    //-------------------------------------------------------------------------------------

    /**
     * function to move a record up in list
     * @param $test_group_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($test_group_id, $page_id = NULL)
    {

        $test_group_id = (int) $test_group_id;



        //get order number of this record
        $this_test_group_where = "test_group_id = $test_group_id";
        $this_test_group = $this->test_group_model->getBy($this_test_group_where, true);
        $this_test_group_id = $test_group_id;
        $this_test_group_order = $this_test_group->order;


        //get order number of next record

        $next_test_group_where = "order >= $this_test_group_order and test_group_id != $test_group_id ORDER BY `order` ASC";
        $next_test_group = $this->test_group_model->getBy($next_test_group_where, true);
        $next_test_group_id = $next_test_group->test_group_id;
        $next_test_group_order = $next_test_group->order;

        //if this is the first element
        if (!$next_test_group_id) {
            redirect(ADMIN_DIR . "test_groups/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_test_group_inputs = array(
            "order" => $next_test_group_order
        );
        $this->test_group_model->save($this_test_group_inputs, $this_test_group_id);

        $next_test_group_inputs = array(
            "order" => $this_test_group_order
        );
        $this->test_group_model->save($next_test_group_inputs, $next_test_group_id);



        redirect(ADMIN_DIR . "test_groups/view/" . $page_id);
    }



    public function save_test_group_data($test_group_id)
    {

        $test_group_id = (int) $test_group_id;

        $test_ids = $this->input->post('test_id');
        foreach ($test_ids as $test_id) {
            $query = "SELECT COUNT(*) as total FROM `test_group_tests` 
			WHERE `test_group_id`='" . $test_group_id . "' 
			AND `test_id`='" . $test_id . "'";
            $query_result = $this->db->query($query);
            $entry_count = $query_result->result()[0]->total;
            if ($entry_count == 0) {
                $this->db->query("INSERT INTO `test_group_tests`(`test_group_id`, `test_id`,  `order`) 
							  VALUES ('" . $test_group_id . "','" . $test_id . "','" . $test_id . "')");
            }
        }
        redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
    }


    public function up_test($test_group_test_id, $test_group_id)
    {

        $test_group_test_id = (int) $test_group_test_id;
        $test_group_id = (int) $test_group_id;

        //get order number of this record
        $this_test_group_test_where = "test_group_test_id = $test_group_test_id AND test_group_id = '" . $test_group_id . "'";
        $this_test_group_test = $this->test_group_test_model->getBy($this_test_group_test_where, true);
        $this_test_group_test_id = $test_group_test_id;
        $this_test_group_test_order = $this_test_group_test->order;


        //get order number of previous record
        $previous_test_group_test_where = "order <= $this_test_group_test_order AND test_group_id = '" . $test_group_id . "' AND  test_group_test_id != $test_group_test_id ORDER BY `order` DESC";
        $previous_test_group_test = $this->test_group_test_model->getBy($previous_test_group_test_where, true);
        $previous_test_group_test_id = $previous_test_group_test->test_group_test_id;
        $previous_test_group_test_order = $previous_test_group_test->order;

        //if this is the first element
        if (!$previous_test_group_test_id) {
            redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
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



        redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
    }
    //-------------------------------------------------------------------------------------

    /**
     * function to move a record up in list
     * @param $test_group_test_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down_test($test_group_test_id, $test_group_id)
    {

        $test_group_test_id = (int) $test_group_test_id;

        $test_group_id = (int) $test_group_id;

        //get order number of this record
        $this_test_group_test_where = "test_group_test_id = $test_group_test_id AND test_group_id = '" . $test_group_id . "'";
        $this_test_group_test = $this->test_group_test_model->getBy($this_test_group_test_where, true);
        $this_test_group_test_id = $test_group_test_id;
        $this_test_group_test_order = $this_test_group_test->order;


        //get order number of next record

        $next_test_group_test_where = "order >= $this_test_group_test_order AND test_group_id = '" . $test_group_id . "' and test_group_test_id != $test_group_test_id ORDER BY `order` ASC";
        $next_test_group_test = $this->test_group_test_model->getBy($next_test_group_test_where, true);
        $next_test_group_test_id = $next_test_group_test->test_group_test_id;
        $next_test_group_test_order = $next_test_group_test->order;

        //if this is the first element
        if (!$next_test_group_test_id) {
            redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
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



        redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
    }


    public function delete_test($test_group_test_id, $test_group_id)
    {

        $test_group_test_id = (int) $test_group_test_id;
        //$this->test_group_test_model->changeStatus($test_group_test_id, "3");

        $this->test_group_test_model->delete(array('test_group_test_id' => $test_group_test_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
    }

    //-----------------------------------------------------

    public function save_test_data($test_group_id)
    {
        $test_group_id = (int) $test_group_id;

        if ($this->test_model->validate_form_data() === TRUE) {

            $test_id = $this->test_model->save_data();
            if ($test_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
            }
        } else {
            redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
        }
    }

    public function add_test_unit()
    {
        $test_unit = $this->db->escape($this->input->post('test_unit'));
        $test_id = (int) $this->input->post('test_id');
        $this->db->query("UPDATE `tests` 
                          SET `unit` = " . $test_unit . " 
                          WHERE `tests`.`test_id` = '" . $test_id . "';");
    }

    public function edit_test_form()
    {

        $this->data['test_group_id'] =  $test_group_id = (int) $this->input->post("test_group_id");
        $this->data['test_id'] =  $test_id = (int) $this->input->post("test_id");
        $test_id = (int) $test_id;
        $this->data["test"] = $this->test_model->get($test_id);

        $this->data["test_categories"] = $this->test_model->getList("test_categories", "test_category_id", "test_category", $where = "`test_categories`.`status` IN (1) ");

        $this->data["test_types"] = $this->test_model->getList("test_types", "test_type_id", "test_type", $where = "`test_types`.`status` IN (1) ");

        $this->load->view(ADMIN_DIR . "test_groups/edit_test_form", $this->data);
    }

    public function update_test_data($test_group_id)
    {
        $test_group_id = (int) $test_group_id;

        if ($this->test_model->validate_form_data() === TRUE) {
            $test_id =  $this->input->post('test_id');
            if ($this->test_model->update_data($test_id)) {
                $this->session->set_flashdata("msg_success", "Test Update Successfully");
                redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
            }
        } else {
            $this->session->set_flashdata("msg_error", "Validation Error");
            redirect(ADMIN_DIR . "test_groups/view_test_group/" . $test_group_id);
        }
    }
}
