<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Invoice_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "invoices";
        $this->pk = "invoice_id";
        $this->status = "status";
        $this->order = "order";
    }

    public function validate_form_data()
    {
        $validation_config = array(

            array(
                "field"  =>  "patient_id",
                "label"  =>  "Patient Id",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "discount",
                "label"  =>  "Discount",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "price",
                "label"  =>  "Price",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "sale_tax",
                "label"  =>  "Sale Tax",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "total_price",
                "label"  =>  "Total Price",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "patient_refer_by",
                "label"  =>  "Patient Refer By",
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

        $inputs["patient_id"]  =  $this->input->post("patient_id");

        $inputs["discount"]  =  $this->input->post("discount");

        $inputs["price"]  =  $this->input->post("price");

        $inputs["sale_tax"]  =  $this->input->post("sale_tax");

        $inputs["total_price"]  =  $this->input->post("total_price");

        $inputs["patient_refer_by"]  =  $this->input->post("patient_refer_by");

        return $this->invoice_model->save($inputs);
    }

    public function update_data($invoice_id, $image_field = NULL)
    {
        $inputs = array();

        $inputs["patient_id"]  =  $this->input->post("patient_id");

        $inputs["discount"]  =  $this->input->post("discount");

        $inputs["price"]  =  $this->input->post("price");

        $inputs["sale_tax"]  =  $this->input->post("sale_tax");

        $inputs["total_price"]  =  $this->input->post("total_price");

        $inputs["patient_refer_by"]  =  $this->input->post("patient_refer_by");

        return $this->invoice_model->save($inputs, $invoice_id);
    }

    //----------------------------------------------------------------
    public function get_invoice_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array(
            "invoices.*", "patients.patient_name", "patients.patient_mobile_no", "patients.patient_gender", "patients.patient_age", "patients.patient_address", "doctors.doctor_name", "doctors.doctor_designation", "patients.history_file_no"
        );
        $join_table = array(
            "patients" => "patients.patient_id = invoices.patient_id",

            "doctors" => "doctors.doctor_id = invoices.patient_refer_by",
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
                $this->invoice_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->invoice_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->invoice_model->joinGet($fields, "invoices", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->invoices = $this->invoice_model->joinGet($fields, "invoices", $join_table, $where);
            return $data;
        } else {
            return $this->invoice_model->joinGet($fields, "invoices", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_invoice($invoice_id)
    {

        $fields = array(
            "invoices.*", "patients.patient_name", "patients.patient_mobile_no", "patients.patient_gender", "patients.patient_address", "patients.patient_age", "doctors.doctor_name", "doctors.doctor_designation"
        );
        $join_table = array(
            "patients" => "patients.patient_id = invoices.patient_id",

            "doctors" => "doctors.doctor_id = invoices.patient_refer_by",
        );
        $where = "invoices.invoice_id = $invoice_id";

        return $this->invoice_model->joinGet($fields, "invoices", $join_table, $where, FALSE, TRUE);
    }
}
