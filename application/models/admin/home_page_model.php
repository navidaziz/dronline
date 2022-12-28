<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Home_page_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "home_page";
        $this->pk = "home_page_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "home_page_content",
                            "label"  =>  "Home Page Content",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "home_page_title",
                            "label"  =>  "Home Page Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "home_page_description",
                            "label"  =>  "Home Page Description",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "home_page_keyword",
                            "label"  =>  "Home Page Keyword",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["home_page_content"]  =  $this->input->post("home_page_content");
                    
                    $inputs["home_page_title"]  =  $this->input->post("home_page_title");
                    
                    $inputs["home_page_description"]  =  $this->input->post("home_page_description");
                    
                    $inputs["home_page_keyword"]  =  $this->input->post("home_page_keyword");
                    
	return $this->home_page_model->save($inputs);
	}	 	

public function update_data($home_page_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["home_page_content"]  =  $this->input->post("home_page_content");
                    
                    $inputs["home_page_title"]  =  $this->input->post("home_page_title");
                    
                    $inputs["home_page_description"]  =  $this->input->post("home_page_description");
                    
                    $inputs["home_page_keyword"]  =  $this->input->post("home_page_keyword");
                    
	return $this->home_page_model->save($inputs, $home_page_id);
	}	
	
    //----------------------------------------------------------------
 public function get_home_page_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("home_page.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->home_page_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->home_page_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->home_page_model->joinGet($fields, "home_page", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->home_page = $this->home_page_model->joinGet($fields, "home_page", $join_table, $where);
			return $data;
		}else{
			return $this->home_page_model->joinGet($fields, "home_page", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_home_page($home_page_id){
	
		$fields = array("home_page.*");
		$join_table = array();
		$where = "home_page.home_page_id = $home_page_id";
		
		return $this->home_page_model->joinGet($fields, "home_page", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

