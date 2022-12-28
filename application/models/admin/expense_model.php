<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Expense_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "expenses";
        $this->pk = "expense_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "expense_type_id",
                            "label"  =>  "Expense Type Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "expense_amount",
                            "label"  =>  "Expense Amount",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "expense_title",
                            "label"  =>  "Expense Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "expense_description",
                            "label"  =>  "Expense Description",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["expense_type_id"]  =  $this->input->post("expense_type_id");
                    
                    $inputs["expense_amount"]  =  $this->input->post("expense_amount");
                    
                    $inputs["expense_title"]  =  $this->input->post("expense_title");
                    
                    $inputs["expense_description"]  =  $this->input->post("expense_description");
                    $inputs['created_date'] = date('Y-m-d H:i:s');
                    
                    if($_FILES["expense_attachment"]["size"] > 0){
                        $inputs["expense_attachment"]  =  $this->router->fetch_class()."/".$this->input->post("expense_attachment");
                    }
                    
	return $this->expense_model->save($inputs);
	}	 	

public function update_data($expense_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["expense_type_id"]  =  $this->input->post("expense_type_id");
                    
                    $inputs["expense_amount"]  =  $this->input->post("expense_amount");
                    
                    $inputs["expense_title"]  =  $this->input->post("expense_title");
                    
                    $inputs["expense_description"]  =  $this->input->post("expense_description");
                    $inputs['created_date'] = date('Y-m-d H:i:s');
                    
                    if($_FILES["expense_attachment"]["size"] > 0){
						//remove previous file....
						$expenses = $this->get_expense($expense_id);
						$file_path = $expenses[0]->expense_attachment;
						$this->delete_file($file_path);
                        $inputs["expense_attachment"]  =  $this->router->fetch_class()."/".$this->input->post("expense_attachment");
                    }
                    
	return $this->expense_model->save($inputs, $expense_id);
	}	
	
    //----------------------------------------------------------------
 public function get_expense_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("expenses.*"
                , "expense_types.expense_type"
            );
		$join_table = array(
            "expense_types" => "expense_types.expense_type_id = expenses.expense_type_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->expense_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->expense_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->expense_model->joinGet($fields, "expenses", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->expenses = $this->expense_model->joinGet($fields, "expenses", $join_table, $where);
			return $data;
		}else{
			return $this->expense_model->joinGet($fields, "expenses", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_expense($expense_id){
	
		$fields = array("expenses.*"
                , "expense_types.expense_type"
            );
		$join_table = array(
            "expense_types" => "expense_types.expense_type_id = expenses.expense_type_id",
        );
		$where = "expenses.expense_id = $expense_id";
		
		return $this->expense_model->joinGet($fields, "expenses", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

