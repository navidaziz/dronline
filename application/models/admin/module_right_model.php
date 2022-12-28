<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Module_right_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "module_rights";
        $this->pk = "module_right_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "role_id",
                            "label"  =>  "Role Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "module_id",
                            "label"  =>  "Module Id",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["role_id"]  =  $this->input->post("role_id");
                    
                    $inputs["module_id"]  =  $this->input->post("module_id");
                    
	return $this->module_right_model->save($inputs);
	}	 	

public function update_data($module_right_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["role_id"]  =  $this->input->post("role_id");
                    
                    $inputs["module_id"]  =  $this->input->post("module_id");
                    
	return $this->module_right_model->save($inputs, $module_right_id);
	}	
	
    //----------------------------------------------------------------
 public function get_module_right_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("module_rights.*"
                , "roles.role_title"
            
                , "modules.module_title"
            );
		$join_table = array(
            "roles" => "roles.ROLE_ID = module_rights.ROLE_ID",
        
            "modules" => "modules.MODULE_ID = module_rights.MODULE_ID",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->module_right_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->module_right_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->module_right_model->joinGet($fields, "module_rights", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->module_rights = $this->module_right_model->joinGet($fields, "module_rights", $join_table, $where);
			return $data;
		}else{
			return $this->module_right_model->joinGet($fields, "module_rights", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_module_right($module_right_id){
	
		$fields = array("module_rights.*"
                , "roles.role_title"
            
                , "modules.module_title"
            );
		$join_table = array(
            "roles" => "roles.ROLE_ID = module_rights.ROLE_ID",
        
            "modules" => "modules.MODULE_ID = module_rights.MODULE_ID",
        );
		$where = "module_rights.module_right_id = $module_right_id";
		
		return $this->module_right_model->joinGet($fields, "module_rights", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

