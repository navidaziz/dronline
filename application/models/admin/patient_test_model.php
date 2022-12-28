<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Patient_test_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "patient_tests";
        $this->pk = "patient_test_id";
        $this->status = "status";
        $this->order = "order";
    }

    public function validate_form_data()
    {
        $validation_config = array(

            array(
                "field"  =>  "invoice_id",
                "label"  =>  "Invoice Id",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "test_id",
                "label"  =>  "Test Id",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "test_price",
                "label"  =>  "Test Price",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "test_time",
                "label"  =>  "Test Time",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "test_result",
                "label"  =>  "Test Result",
                "rules"  =>  "required"
            ),

        );
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        return $this->form_validation->run();
    }

    public function save_data($image_field = NULL)
    {
        $inputs = array();

        $inputs["invoice_id"]  =  $this->input->post("invoice_id");

        $inputs["test_id"]  =  $this->input->post("test_id");

        $inputs["test_price"]  =  $this->input->post("test_price");

        $inputs["test_time"]  =  $this->input->post("test_time");

        $inputs["test_result"]  =  $this->input->post("test_result");

        return $this->patient_test_model->save($inputs);
    }

    public function update_data($patient_test_id, $image_field = NULL)
    {
        $inputs = array();

        $inputs["invoice_id"]  =  $this->input->post("invoice_id");

        $inputs["test_id"]  =  $this->input->post("test_id");

        $inputs["test_price"]  =  $this->input->post("test_price");

        $inputs["test_time"]  =  $this->input->post("test_time");

        $inputs["test_result"]  =  $this->input->post("test_result");

        return $this->patient_test_model->save($inputs, $patient_test_id);
    }

    //----------------------------------------------------------------
    public function get_patient_test_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array(
            "patient_tests.*", "tests.test_name", "tests.unit", "tests.result_suffix", "invoices.invoice_id"
        );
        $join_table = array(
            "tests" => "tests.test_id = patient_tests.test_id",

            "invoices" => "invoices.invoice_id = patient_tests.invoice_id",
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
                $this->patient_test_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->patient_test_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->patient_test_model->joinGet($fields, "patient_tests", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->patient_tests = $this->patient_test_model->joinGet($fields, "patient_tests", $join_table, $where);
            return $data;
        } else {
            return $this->patient_test_model->joinGet($fields, "patient_tests", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_patient_test($patient_test_id)
    {

        $fields = array(
            "patient_tests.*", "tests.test_name", "tests.unit", "invoices.invoice_id"
        );
        $join_table = array(
            "tests" => "tests.test_id = patient_tests.test_id",

            "invoices" => "invoices.invoice_id = patient_tests.invoice_id",
        );
        $where = "patient_tests.patient_test_id = $patient_test_id";

        return $this->patient_test_model->joinGet($fields, "patient_tests", $join_table, $where, FALSE, TRUE);
    }
}
