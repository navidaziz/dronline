<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Test_category_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "test_categories";
        $this->pk = "test_category_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "test_category",
                            "label"  =>  "Test Category",
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
            
                    $inputs["test_category"]  =  $this->input->post("test_category");
                    
                    $inputs["description"]  =  $this->input->post("description");
                    
                    if($_FILES["image"]["size"] > 0){
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->test_category_model->save($inputs);
	}	 	

public function update_data($test_category_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["test_category"]  =  $this->input->post("test_category");
                    
                    $inputs["description"]  =  $this->input->post("description");
                    
                    if($_FILES["image"]["size"] > 0){
						//remove previous file....
						$test_categories = $this->get_test_category($test_category_id);
						$file_path = $test_categories[0]->image;
						$this->delete_file($file_path);
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->test_category_model->save($inputs, $test_category_id);
	}	
	
    //----------------------------------------------------------------
 public function get_test_category_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("test_categories.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->test_category_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->test_category_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->test_category_model->joinGet($fields, "test_categories", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->test_categories = $this->test_category_model->joinGet($fields, "test_categories", $join_table, $where);
			return $data;
		}else{
			return $this->test_category_model->joinGet($fields, "test_categories", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_test_category($test_category_id){
	
		$fields = array("test_categories.*");
		$join_table = array();
		$where = "test_categories.test_category_id = $test_category_id";
		
		return $this->test_category_model->joinGet($fields, "test_categories", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

