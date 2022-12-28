<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Suppliers_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "supplier";
        $this->pk = "supplier_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
	return $this->suppliers_model->save($inputs);
	}	 	

public function update_data($supplier_id, $image_field= NULL){
	$inputs = array();
            
	return $this->suppliers_model->save($inputs, $supplier_id);
	}	
	
    //----------------------------------------------------------------
 public function get_suppliers_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("supplier.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->suppliers_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->suppliers_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->suppliers_model->joinGet($fields, "supplier", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->supplier = $this->suppliers_model->joinGet($fields, "supplier", $join_table, $where);
			return $data;
		}else{
			return $this->suppliers_model->joinGet($fields, "supplier", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_suppliers($supplier_id){
	
		$fields = array("supplier.*");
		$join_table = array();
		$where = "supplier.supplier_id = $supplier_id";
		
		return $this->suppliers_model->joinGet($fields, "supplier", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

