<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Test_group_test_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "test_group_tests";
        $this->pk = "test_group_test_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "test_id",
                            "label"  =>  "Test Id",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["test_id"]  =  $this->input->post("test_id");
                    
	return $this->test_group_test_model->save($inputs);
	}	 	

public function update_data($test_group_test_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["test_id"]  =  $this->input->post("test_id");
                    
	return $this->test_group_test_model->save($inputs, $test_group_test_id);
	}	
	
    //----------------------------------------------------------------
 public function get_test_group_test_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("test_group_tests.*"
                , "tests.test_name"
            );
		$join_table = array(
            "tests" => "tests.test_id = test_group_tests.test_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->test_group_test_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->test_group_test_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->test_group_test_model->joinGet($fields, "test_group_tests", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->test_group_tests = $this->test_group_test_model->joinGet($fields, "test_group_tests", $join_table, $where);
			return $data;
		}else{
			return $this->test_group_test_model->joinGet($fields, "test_group_tests", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_test_group_test($test_group_test_id){
	
		$fields = array("test_group_tests.*"
                , "tests.test_name"
            );
		$join_table = array(
            "tests" => "tests.test_id = test_group_tests.test_id",
        );
		$where = "test_group_tests.test_group_test_id = $test_group_test_id";
		
		return $this->test_group_test_model->joinGet($fields, "test_group_tests", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

