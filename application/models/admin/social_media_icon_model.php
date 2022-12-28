<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Social_media_icon_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "social_media_icons";
        $this->pk = "social_media_icon_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "social_media_name",
                            "label"  =>  "Social Media Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "social_media_icon",
                            "label"  =>  "Social Media Icon",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "social_media_link",
                            "label"  =>  "Social Media Link",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["social_media_name"]  =  $this->input->post("social_media_name");
                    
                    if($_FILES["social_media_image"]["size"] > 0){
                        $inputs["social_media_image"]  =  $this->router->fetch_class()."/".$this->input->post("social_media_image");
                    }
                    
                    $inputs["social_media_icon"]  =  $this->input->post("social_media_icon");
                    
                    $inputs["social_media_link"]  =  $this->input->post("social_media_link");
                    
	return $this->social_media_icon_model->save($inputs);
	}	 	

public function update_data($social_media_icon_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["social_media_name"]  =  $this->input->post("social_media_name");
                    
                    if($_FILES["social_media_image"]["size"] > 0){
						//remove previous file....
						$social_media_icons = $this->get_social_media_icon($social_media_icon_id);
						$file_path = $social_media_icons[0]->social_media_image;
						$this->delete_file($file_path);
                        $inputs["social_media_image"]  =  $this->router->fetch_class()."/".$this->input->post("social_media_image");
                    }
                    
                    $inputs["social_media_icon"]  =  $this->input->post("social_media_icon");
                    
                    $inputs["social_media_link"]  =  $this->input->post("social_media_link");
                    
	return $this->social_media_icon_model->save($inputs, $social_media_icon_id);
	}	
	
    //----------------------------------------------------------------
 public function get_social_media_icon_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("social_media_icons.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->social_media_icon_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->social_media_icon_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->social_media_icon_model->joinGet($fields, "social_media_icons", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->social_media_icons = $this->social_media_icon_model->joinGet($fields, "social_media_icons", $join_table, $where);
			return $data;
		}else{
			return $this->social_media_icon_model->joinGet($fields, "social_media_icons", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_social_media_icon($social_media_icon_id){
	
		$fields = array("social_media_icons.*");
		$join_table = array();
		$where = "social_media_icons.social_media_icon_id = $social_media_icon_id";
		
		return $this->social_media_icon_model->joinGet($fields, "social_media_icons", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

