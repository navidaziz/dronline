<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Patient_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "patients";
        $this->pk = "patient_id";
        $this->status = "status";
        $this->order = "order";
    }

    public function validate_form_data()
    {
        $validation_config = array(

            array(
                "field"  =>  "patient_name",
                "label"  =>  "Patient Name",
                "rules"  =>  "required"
            ),

            // array(
            //     "field"  =>  "patient_mobile_no",
            //     "label"  =>  "Patient Mobile No",
            //     "rules"  =>  "required"
            // ),

            array(
                "field"  =>  "patient_address",
                "label"  =>  "Patient Address",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "patient_gender",
                "label"  =>  "Patient Gender",
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


        $inputs["patient_name"]  =  ucwords(strtolower($this->input->post("patient_name")));
        $inputs["patient_age"]  =  $this->input->post("patient_age");
        $inputs["patient_mobile_no"]  =  preg_replace("/[^0-9,.]/", "", $this->input->post('patient_mobile_no'));

        $inputs["patient_address"]  =  ucwords(strtolower($this->input->post("patient_address")));

        $inputs["patient_gender"]  =  $this->input->post("patient_gender");


        return $this->patient_model->save($inputs);
    }

    public function update_data($patient_id, $image_field = NULL)
    {
        $inputs = array();

        $inputs["patient_name"]  =  ucwords(strtolower($this->input->post("patient_name")));

        $inputs["patient_mobile_no"]  =  preg_replace("/[^0-9,.]/", "", $this->input->post('patient_mobile_no'));

        $inputs["patient_address"]  =  ucwords(strtolower($this->input->post("patient_address")));
        $inputs["patient_age"]  =  $this->input->post("patient_age");
        $inputs["patient_gender"]  =  $this->input->post("patient_gender");

        return $this->patient_model->save($inputs, $patient_id);
    }

    //----------------------------------------------------------------
    public function get_patient_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array("patients.*");
        $join_table = array();
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
                $this->patient_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->patient_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->patient_model->joinGet($fields, "patients", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->patients = $this->patient_model->joinGet($fields, "patients", $join_table, $where);
            return $data;
        } else {
            return $this->patient_model->joinGet($fields, "patients", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_patient($patient_id)
    {

        $fields = array("patients.*");
        $join_table = array();
        $where = "patients.patient_id = $patient_id";

        return $this->patient_model->joinGet($fields, "patients", $join_table, $where, FALSE, TRUE);
    }
}
