<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class System_global_setting_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "system_global_settings";
        $this->pk = "system_global_setting_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "system_title",
                            "label"  =>  "System Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "system_sub_title",
                            "label"  =>  "System Sub Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "phone_number",
                            "label"  =>  "Phone Number",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "mobile_number",
                            "label"  =>  "Mobile Number",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "fax_number",
                            "label"  =>  "Fax Number",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "email_address",
                            "label"  =>  "Email Address",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "address",
                            "label"  =>  "Address",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "web_address",
                            "label"  =>  "Web Address",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "description",
                            "label"  =>  "Description",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["system_title"]  =  $this->input->post("system_title");
                    
                    $inputs["system_sub_title"]  =  $this->input->post("system_sub_title");
                    
                    if($_FILES["sytem_public_logo"]["size"] > 0){
                        $inputs["sytem_public_logo"]  =  $this->router->fetch_class()."/".$this->input->post("sytem_public_logo");
                    }
                    
                    if($_FILES["sytem_admin_logo"]["size"] > 0){
                        $inputs["sytem_admin_logo"]  =  $this->router->fetch_class()."/".$this->input->post("sytem_admin_logo");
                    }
                    
                    $inputs["phone_number"]  =  $this->input->post("phone_number");
                    
                    $inputs["mobile_number"]  =  $this->input->post("mobile_number");
                    
                    $inputs["fax_number"]  =  $this->input->post("fax_number");
                    
                    $inputs["email_address"]  =  $this->input->post("email_address");
                    
                    $inputs["address"]  =  $this->input->post("address");
                    
                    $inputs["web_address"]  =  $this->input->post("web_address");
                    
                    $inputs["description"]  =  $this->input->post("description");
                    
	return $this->system_global_setting_model->save($inputs);
	}	 	

public function update_data($system_global_setting_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["system_title"]  =  $this->input->post("system_title");
                    
                    $inputs["system_sub_title"]  =  $this->input->post("system_sub_title");
                    
                    if($_FILES["sytem_public_logo"]["size"] > 0){
						//remove previous file....
						$system_global_settings = $this->get_system_global_setting($system_global_setting_id);
						$file_path = $system_global_settings[0]->sytem_public_logo;
						$this->delete_file($file_path);
                        $inputs["sytem_public_logo"]  =  $this->router->fetch_class()."/".$this->input->post("sytem_public_logo");
                    }
                    
                    if($_FILES["sytem_admin_logo"]["size"] > 0){
						//remove previous file....
						$system_global_settings = $this->get_system_global_setting($system_global_setting_id);
						$file_path = $system_global_settings[0]->sytem_admin_logo;
						$this->delete_file($file_path);
                        $inputs["sytem_admin_logo"]  =  $this->router->fetch_class()."/".$this->input->post("sytem_admin_logo");
                    }
                    
                    $inputs["phone_number"]  =  $this->input->post("phone_number");
                    
                    $inputs["mobile_number"]  =  $this->input->post("mobile_number");
                    
                    $inputs["fax_number"]  =  $this->input->post("fax_number");
                    
                    $inputs["email_address"]  =  $this->input->post("email_address");
                    
                    $inputs["address"]  =  $this->input->post("address");
                    
                    $inputs["web_address"]  =  $this->input->post("web_address");
                    
                    $inputs["description"]  =  $this->input->post("description");
                    
	return $this->system_global_setting_model->save($inputs, $system_global_setting_id);
	}	
	
    //----------------------------------------------------------------
 public function get_system_global_setting_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("system_global_settings.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->system_global_setting_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->system_global_setting_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->system_global_setting_model->joinGet($fields, "system_global_settings", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->system_global_settings = $this->system_global_setting_model->joinGet($fields, "system_global_settings", $join_table, $where);
			return $data;
		}else{
			return $this->system_global_setting_model->joinGet($fields, "system_global_settings", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_system_global_setting($system_global_setting_id){
	
		$fields = array("system_global_settings.*");
		$join_table = array();
		$where = "system_global_settings.system_global_setting_id = $system_global_setting_id";
		
		return $this->system_global_setting_model->joinGet($fields, "system_global_settings", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

