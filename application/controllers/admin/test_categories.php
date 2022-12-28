<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test_categories extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/test_category_model");
        $this->load->model("admin/test_type_model");

        $this->lang->load("test_categories", 'english');
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

        $where = "`test_categories`.`status` IN (0, 1) ORDER BY `test_categories`.`order`";
        $data = $this->test_category_model->get_test_category_list($where);
        $this->data["test_categories"] = $data->test_categories;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Test Categories');
        $this->data["view"] = ADMIN_DIR . "test_categories/test_categories";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_test_category($test_category_id)
    {

        $test_category_id = (int) $test_category_id;

        $this->data["test_categories"] = $this->test_category_model->get_test_category($test_category_id);
        $this->data["title"] = $this->lang->line('Test Category Details');
        $this->data["view"] = ADMIN_DIR . "test_categories/view_test_category";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`test_categories`.`status` IN (2) ORDER BY `test_categories`.`order`";
        $data = $this->test_category_model->get_test_category_list($where);
        $this->data["test_categories"] = $data->test_categories;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Test Categories');
        $this->data["view"] = ADMIN_DIR . "test_categories/trashed_test_categories";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($test_category_id, $page_id = NULL)
    {

        $test_category_id = (int) $test_category_id;


        $this->test_category_model->changeStatus($test_category_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR . "test_categories/view/" . $page_id);
    }

    /**
     * function to restor test_category from trash
     * @param $test_category_id integer
     */
    public function restore($test_category_id, $page_id = NULL)
    {

        $test_category_id = (int) $test_category_id;


        $this->test_category_model->changeStatus($test_category_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR . "test_categories/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft test_category from trash
     * @param $test_category_id integer
     */
    public function draft($test_category_id, $page_id = NULL)
    {

        $test_category_id = (int) $test_category_id;


        $this->test_category_model->changeStatus($test_category_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR . "test_categories/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish test_category from trash
     * @param $test_category_id integer
     */
    public function publish($test_category_id, $page_id = NULL)
    {

        $test_category_id = (int) $test_category_id;


        $this->test_category_model->changeStatus($test_category_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR . "test_categories/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a Test_category
     * @param $test_category_id integer
     */
    public function delete($test_category_id, $page_id = NULL)
    {

        $test_category_id = (int) $test_category_id;
        $this->test_category_model->changeStatus($test_category_id, "3");
        //Remove file....
        //$test_categories = $this->test_category_model->get_test_category($test_category_id);
        //$file_path = $test_categories[0]->image;
        //$this->test_category_model->delete_file($file_path);
        //$this->test_category_model->delete(array('test_category_id' => $test_category_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR . "test_categories/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new Test_category
     */
    public function add()
    {

        $this->data["title"] = $this->lang->line('Add New Test Category');
        $this->data["view"] = ADMIN_DIR . "test_categories/add_test_category";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function save_data()
    {
        if ($this->test_category_model->validate_form_data() === TRUE) {

            if ($this->upload_file("image")) {
                $_POST['image'] = $this->data["upload_data"]["file_name"];
            }

            $test_category_id = $this->test_category_model->save_data();
            if ($test_category_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR . "test_categories/edit/$test_category_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "test_categories/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a Test_category
     */
    public function edit($test_category_id)
    {
        $test_category_id = (int) $test_category_id;
        $this->data["test_category"] = $this->test_category_model->get($test_category_id);

        $this->data["title"] = $this->lang->line('Edit Test Category');
        $this->data["view"] = ADMIN_DIR . "test_categories/edit_test_category";
        $this->load->view(ADMIN_DIR . "layout", $this->data);
    }
    //--------------------------------------------------------------------

    public function update_data($test_category_id)
    {

        $test_category_id = (int) $test_category_id;

        if ($this->test_category_model->validate_form_data() === TRUE) {

            if ($this->upload_file("image")) {
                $_POST["image"] = $this->data["upload_data"]["file_name"];
            }

            $test_category_id = $this->test_category_model->update_data($test_category_id);
            if ($test_category_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR . "test_categories/edit/$test_category_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR . "test_categories/edit/$test_category_id");
            }
        } else {
            $this->edit($test_category_id);
        }
    }


    /**
     * function to move a record up in list
     * @param $test_category_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($test_category_id, $page_id = NULL)
    {

        $test_category_id = (int) $test_category_id;

        //get order number of this record
        $this_test_category_where = "test_category_id = $test_category_id";
        $this_test_category = $this->test_category_model->getBy($this_test_category_where, true);
        $this_test_category_id = $test_category_id;
        $this_test_category_order = $this_test_category->order;


        //get order number of previous record
        $previous_test_category_where = "order <= $this_test_category_order AND test_category_id != $test_category_id ORDER BY `order` DESC";
        $previous_test_category = $this->test_category_model->getBy($previous_test_category_where, true);
        $previous_test_category_id = $previous_test_category->test_category_id;
        $previous_test_category_order = $previous_test_category->order;

        //if this is the first element
        if (!$previous_test_category_id) {
            redirect(ADMIN_DIR . "test_categories/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_test_category_inputs = array(
            "order" => $previous_test_category_order
        );
        $this->test_category_model->save($this_test_category_inputs, $this_test_category_id);

        $previous_test_category_inputs = array(
            "order" => $this_test_category_order
        );
        $this->test_category_model->save($previous_test_category_inputs, $previous_test_category_id);



        redirect(ADMIN_DIR . "test_categories/view/" . $page_id);
    }
    //-------------------------------------------------------------------------------------

    /**
     * function to move a record up in list
     * @param $test_category_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($test_category_id, $page_id = NULL)
    {

        $test_category_id = (int) $test_category_id;



        //get order number of this record
        $this_test_category_where = "test_category_id = $test_category_id";
        $this_test_category = $this->test_category_model->getBy($this_test_category_where, true);
        $this_test_category_id = $test_category_id;
        $this_test_category_order = $this_test_category->order;


        //get order number of next record

        $next_test_category_where = "order >= $this_test_category_order and test_category_id != $test_category_id ORDER BY `order` ASC";
        $next_test_category = $this->test_category_model->getBy($next_test_category_where, true);
        $next_test_category_id = $next_test_category->test_category_id;
        $next_test_category_order = $next_test_category->order;

        //if this is the first element
        if (!$next_test_category_id) {
            redirect(ADMIN_DIR . "test_categories/view/" . $page_id);
            exit;
        }


        //now swap the order
        $this_test_category_inputs = array(
            "order" => $next_test_category_order
        );
        $this->test_category_model->save($this_test_category_inputs, $this_test_category_id);

        $next_test_category_inputs = array(
            "order" => $this_test_category_order
        );
        $this->test_category_model->save($next_test_category_inputs, $next_test_category_id);



        redirect(ADMIN_DIR . "test_categories/view/" . $page_id);
    }

    /**
     * get data as a json array 
     */
    public function get_json()
    {
        $where = array("status" => 1);
        $where[$this->uri->segment(3)] = $this->uri->segment(4);
        $data["test_categories"] = $this->test_category_model->getBy($where, false, "test_category_id");
        $j_array[] = array("id" => "", "value" => "test_category");
        foreach ($data["test_categories"] as $test_category) {
            $j_array[] = array("id" => $test_category->test_category_id, "value" => "");
        }
        echo json_encode($j_array);
    }
    //-----------------------------------------------------

}
