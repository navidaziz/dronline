<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Supplier_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "suppliers";
        $this->pk = "supplier_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "supplier_name",
                            "label"  =>  "Supplier Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "supplier_contact_no",
                            "label"  =>  "Supplier Contact No",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "company_name",
                            "label"  =>  "Company Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "account_number",
                            "label"  =>  "Account Number",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["supplier_name"]  =  $this->input->post("supplier_name");
                    
                    $inputs["supplier_contact_no"]  =  $this->input->post("supplier_contact_no");
                    
                    $inputs["company_name"]  =  $this->input->post("company_name");
                    
                    $inputs["account_number"]  =  $this->input->post("account_number");
                    
	return $this->supplier_model->save($inputs);
	}	 	

public function update_data($supplier_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["supplier_name"]  =  $this->input->post("supplier_name");
                    
                    $inputs["supplier_contact_no"]  =  $this->input->post("supplier_contact_no");
                    
                    $inputs["company_name"]  =  $this->input->post("company_name");
                    
                    $inputs["account_number"]  =  $this->input->post("account_number");
                    
	return $this->supplier_model->save($inputs, $supplier_id);
	}	
	
    //----------------------------------------------------------------
 public function get_supplier_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("suppliers.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->supplier_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->supplier_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->supplier_model->joinGet($fields, "suppliers", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->suppliers = $this->supplier_model->joinGet($fields, "suppliers", $join_table, $where);
			return $data;
		}else{
			return $this->supplier_model->joinGet($fields, "suppliers", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_supplier($supplier_id){
	
		$fields = array("suppliers.*");
		$join_table = array();
		$where = "suppliers.supplier_id = $supplier_id";
		
		return $this->supplier_model->joinGet($fields, "suppliers", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

