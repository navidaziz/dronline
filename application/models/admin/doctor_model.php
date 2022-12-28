<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Doctor_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "doctors";
        $this->pk = "doctor_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "doctor_name",
                            "label"  =>  "Doctor Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "doctor_designation",
                            "label"  =>  "Doctor Designation",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["doctor_name"]  =  $this->input->post("doctor_name");
                    
                    $inputs["doctor_designation"]  =  $this->input->post("doctor_designation");
                    
	return $this->doctor_model->save($inputs);
	}	 	

public function update_data($doctor_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["doctor_name"]  =  $this->input->post("doctor_name");
                    
                    $inputs["doctor_designation"]  =  $this->input->post("doctor_designation");
                    
	return $this->doctor_model->save($inputs, $doctor_id);
	}	
	
    //----------------------------------------------------------------
 public function get_doctor_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("doctors.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->doctor_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->doctor_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->doctor_model->joinGet($fields, "doctors", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->doctors = $this->doctor_model->joinGet($fields, "doctors", $join_table, $where);
			return $data;
		}else{
			return $this->doctor_model->joinGet($fields, "doctors", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_doctor($doctor_id){
	
		$fields = array("doctors.*");
		$join_table = array();
		$where = "doctors.doctor_id = $doctor_id";
		
		return $this->doctor_model->joinGet($fields, "doctors", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

