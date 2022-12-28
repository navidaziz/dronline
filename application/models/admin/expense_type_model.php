<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Expense_type_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "expense_types";
        $this->pk = "expense_type_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "expense_type",
                            "label"  =>  "Expense Type",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["expense_type"]  =  $this->input->post("expense_type");
                    
	return $this->expense_type_model->save($inputs);
	}	 	

public function update_data($expense_type_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["expense_type"]  =  $this->input->post("expense_type");
                    
	return $this->expense_type_model->save($inputs, $expense_type_id);
	}	
	
    //----------------------------------------------------------------
 public function get_expense_type_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("expense_types.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->expense_type_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->expense_type_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->expense_type_model->joinGet($fields, "expense_types", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->expense_types = $this->expense_type_model->joinGet($fields, "expense_types", $join_table, $where);
			return $data;
		}else{
			return $this->expense_type_model->joinGet($fields, "expense_types", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_expense_type($expense_type_id){
	
		$fields = array("expense_types.*");
		$join_table = array();
		$where = "expense_types.expense_type_id = $expense_type_id";
		
		return $this->expense_type_model->joinGet($fields, "expense_types", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

