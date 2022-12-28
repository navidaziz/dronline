<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Item_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "items";
        $this->pk = "item_id";
        $this->status = "status";
        $this->order = "order";
    }

    public function validate_form_data($operation = false)
    {
        $validation_config = array(

            array(
                "field"  =>  "name",
                "label"  =>  "Name",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "category",
                "label"  =>  "Category",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "cost_price",
                "label"  =>  "Cost Price",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "unit_price",
                "label"  =>  "Unit Price",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "reorder_level",
                "label"  =>  "Reorder Level",
                "rules"  =>  "required"
            ),
            array(
                "field"  =>  "description",
                "label"  =>  "Discription",
                "rules"  =>  ""
            ),
            array(
                "field"  =>  "unit",
                "label"  =>  "Unit",
                "rules"  =>  ""
            ),
            array(
                "field"  =>  "location",
                "label"  =>  "Location",
                "rules"  =>  ""
            ),


        );
        if ($operation) {
            $validation_config[] = array(
                "field"  =>  "item_code_no",
                "label"  =>  "Reorder Level",
                "rules"  =>  "is_unique[items.item_code_no]"
            );
        }
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        return $this->form_validation->run();
    }

    public function save_data($image_field = NULL)
    {
        $inputs = array();

        $inputs["name"]  =  $this->input->post("name");

        $inputs["category"]  =  $this->input->post("category");

        $inputs["item_code_no"]  =  $this->input->post("item_code_no");

        $inputs["description"]  =  $this->input->post("description");

        $inputs["cost_price"]  =  $this->input->post("cost_price");

        $inputs["unit_price"]  =  $this->input->post("unit_price");

        $inputs["unit"]  =  $this->input->post("unit");

        $inputs["reorder_level"]  =  $this->input->post("reorder_level");

        $inputs["location"]  =  $this->input->post("location");

        return $this->item_model->save($inputs);
    }

    public function update_data($item_id, $image_field = NULL)
    {
        $inputs = array();

        $inputs["name"]  =  $this->input->post("name");

        $inputs["category"]  =  $this->input->post("category");

        //$inputs["item_code_no"]  =  $this->input->post("item_code_no");

        $inputs["description"]  =  $this->input->post("description");

        $inputs["cost_price"]  =  $this->input->post("cost_price");

        $inputs["unit_price"]  =  $this->input->post("unit_price");

        $inputs["unit"]  =  $this->input->post("unit");

        $inputs["reorder_level"]  =  $this->input->post("reorder_level");

        $inputs["location"]  =  $this->input->post("location");
        $inputs["discount"]  =  $this->input->post("discount");

        return $this->item_model->save($inputs, $item_id);
    }

    //----------------------------------------------------------------
    public function get_item_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array("items.*");
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
                $this->item_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->item_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->item_model->joinGet($fields, "items", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->items = $this->item_model->joinGet($fields, "items", $join_table, $where);
            return $data;
        } else {
            return $this->item_model->joinGet($fields, "items", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_item($item_id)
    {

        $fields = array("items.*");
        $join_table = array();
        $where = "items.item_id = $item_id";

        return $this->item_model->joinGet($fields, "items", $join_table, $where, FALSE, TRUE);
    }
}
