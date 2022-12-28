<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Test_type_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "test_types";
        $this->pk = "test_type_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "test_category_id",
                            "label"  =>  "Test Category Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "test_type",
                            "label"  =>  "Test Type",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "test_description",
                            "label"  =>  "Test Description",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["test_category_id"]  =  $this->input->post("test_category_id");
                    
                    $inputs["test_type"]  =  $this->input->post("test_type");
                    
                    $inputs["test_description"]  =  $this->input->post("test_description");
                    
                    if($_FILES["image"]["size"] > 0){
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->test_type_model->save($inputs);
	}	 	

public function update_data($test_type_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["test_category_id"]  =  $this->input->post("test_category_id");
                    
                    $inputs["test_type"]  =  $this->input->post("test_type");
                    
                    $inputs["test_description"]  =  $this->input->post("test_description");
                    
                    if($_FILES["image"]["size"] > 0){
						//remove previous file....
						$test_types = $this->get_test_type($test_type_id);
						$file_path = $test_types[0]->image;
						$this->delete_file($file_path);
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->test_type_model->save($inputs, $test_type_id);
	}	
	
    //----------------------------------------------------------------
 public function get_test_type_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("test_types.*"
                , "test_categories.test_category"
            );
		$join_table = array(
            "test_categories" => "test_categories.test_category_id = test_types.test_category_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->test_type_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->test_type_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->test_type_model->joinGet($fields, "test_types", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->test_types = $this->test_type_model->joinGet($fields, "test_types", $join_table, $where);
			return $data;
		}else{
			return $this->test_type_model->joinGet($fields, "test_types", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_test_type($test_type_id){
	
		$fields = array("test_types.*"
                , "test_categories.test_category"
            );
		$join_table = array(
            "test_categories" => "test_categories.test_category_id = test_types.test_category_id",
        );
		$where = "test_types.test_type_id = $test_type_id";
		
		return $this->test_type_model->joinGet($fields, "test_types", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

