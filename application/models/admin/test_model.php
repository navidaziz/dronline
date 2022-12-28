<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Test_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "tests";
        $this->pk = "test_id";
        $this->status = "status";
        $this->order = "order";
    }

    public function validate_form_data()
    {
        $validation_config = array(

            array(
                "field"  =>  "test_category_id",
                "label"  =>  "Test Category Id",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "test_type_id",
                "label"  =>  "Test Type Id",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "test_name",
                "label"  =>  "Test Name",
                "rules"  =>  "required"
            ),

            // array(
            //     "field"  =>  "test_time",
            //     "label"  =>  "Test Time",
            //     "rules"  =>  "required"
            // ),

            // array(
            //     "field"  =>  "test_price",
            //     "label"  =>  "Test Price",
            //     "rules"  =>  "required"
            // ),


        );
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        return $this->form_validation->run();
    }

    public function save_data($image_field = NULL)
    {
        $inputs = array();

        $inputs["test_category_id"]  =  $this->input->post("test_category_id");

        $inputs["test_type_id"]  =  $this->input->post("test_type_id");

        $inputs["test_name"]  =  $this->input->post("test_name");

        $inputs["test_time"]  =  $this->input->post("test_time");

        $inputs["test_price"]  =  $this->input->post("test_price");

        $inputs["test_description"]  =  $this->input->post("test_description");

        $inputs["normal_values"]  =  $this->input->post("normal_values");
        $inputs["unit"]  =  $this->input->post("test_unit");
        $inputs["result_suffix"]  =  $this->input->post("result_suffix");

        return $this->test_model->save($inputs);
    }

    public function update_data($test_id, $image_field = NULL)
    {
        $inputs = array();

        $inputs["test_category_id"]  =  $this->input->post("test_category_id");

        $inputs["test_type_id"]  =  $this->input->post("test_type_id");

        $inputs["test_name"]  =  $this->input->post("test_name");

        $inputs["test_time"]  =  $this->input->post("test_time");

        $inputs["test_price"]  =  $this->input->post("test_price");

        $inputs["test_description"]  =  $this->input->post("test_description");

        $inputs["normal_values"]  =  $this->input->post("normal_values");
        $inputs["unit"]  =  $this->input->post("test_unit");
        $inputs["result_suffix"]  =  $this->input->post("result_suffix");

        return $this->test_model->save($inputs, $test_id);
    }

    //----------------------------------------------------------------
    public function get_test_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array(
            "tests.*", "test_categories.test_category", "test_types.test_type"
        );
        $join_table = array(
            "test_categories" => "test_categories.test_category_id = tests.test_category_id",

            "test_types" => "test_types.test_type_id = tests.test_type_id",
        );
        if (!is_null($where_condition)) {
            $where = $where_condition;
        } else {
            $where = "";
        }

        if ($pagination) {
            //configure the pagination
            $this->load->library("pagination");

            if ($public) {
                $config['per_page'] = 10;
                $config['uri_segment'] = 3;
                $this->test_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->test_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->test_model->joinGet($fields, "tests", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->tests = $this->test_model->joinGet($fields, "tests", $join_table, $where);
            return $data;
        } else {
            return $this->test_model->joinGet($fields, "tests", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_test($test_id)
    {

        $fields = array(
            "tests.*", "test_categories.test_category", "test_types.test_type"
        );
        $join_table = array(
            "test_categories" => "test_categories.test_category_id = tests.test_category_id",

            "test_types" => "test_types.test_type_id = tests.test_type_id",
        );
        $where = "tests.test_id = $test_id";

        return $this->test_model->joinGet($fields, "tests", $join_table, $where, FALSE, TRUE);
    }
}
