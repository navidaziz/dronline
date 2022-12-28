<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Module_rights extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/module_right_model");
		$this->lang->load("module_rights", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`module_rights`.`status` IN (0, 1) ORDER BY `module_rights`.`order`";
		$data = $this->module_right_model->get_module_right_list($where);
		 $this->data["module_rights"] = $data->module_rights;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Module Rights');
		$this->data["view"] = ADMIN_DIR."module_rights/module_rights";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_module_right($module_right_id){
        
        $module_right_id = (int) $module_right_id;
        
        $this->data["module_rights"] = $this->module_right_model->get_module_right($module_right_id);
        $this->data["title"] = $this->lang->line('Module Right Details');
		$this->data["view"] = ADMIN_DIR."module_rights/view_module_right";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`module_rights`.`status` IN (2) ORDER BY `module_rights`.`order`";
		$data = $this->module_right_model->get_module_right_list($where);
		 $this->data["module_rights"] = $data->module_rights;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Module Rights');
		$this->data["view"] = ADMIN_DIR."module_rights/trashed_module_rights";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($module_right_id, $page_id = NULL){
        
        $module_right_id = (int) $module_right_id;
        
        
        $this->module_right_model->changeStatus($module_right_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."module_rights/view/".$page_id);
    }
    
    /**
      * function to restor module_right from trash
      * @param $module_right_id integer
      */
     public function restore($module_right_id, $page_id = NULL){
        
        $module_right_id = (int) $module_right_id;
        
        
        $this->module_right_model->changeStatus($module_right_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."module_rights/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft module_right from trash
      * @param $module_right_id integer
      */
     public function draft($module_right_id, $page_id = NULL){
        
        $module_right_id = (int) $module_right_id;
        
        
        $this->module_right_model->changeStatus($module_right_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."module_rights/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish module_right from trash
      * @param $module_right_id integer
      */
     public function publish($module_right_id, $page_id = NULL){
        
        $module_right_id = (int) $module_right_id;
        
        
        $this->module_right_model->changeStatus($module_right_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."module_rights/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Module_right
      * @param $module_right_id integer
      */
     public function delete($module_right_id, $page_id = NULL){
        
        $module_right_id = (int) $module_right_id;
        //$this->module_right_model->changeStatus($module_right_id, "3");
        
		$this->module_right_model->delete(array( 'module_right_id' => $module_right_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."module_rights/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Module_right
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Module Right');$this->data["view"] = ADMIN_DIR."module_rights/add_module_right";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->module_right_model->validate_form_data() === TRUE){
		  
		  $module_right_id = $this->module_right_model->save_data();
          if($module_right_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."module_rights/edit/$module_right_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."module_rights/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Module_right
      */
     public function edit($module_right_id){
		 $module_right_id = (int) $module_right_id;
        $this->data["module_right"] = $this->module_right_model->get($module_right_id);
		  
        $this->data["title"] = $this->lang->line('Edit Module Right');$this->data["view"] = ADMIN_DIR."module_rights/edit_module_right";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($module_right_id){
		 
		 $module_right_id = (int) $module_right_id;
       
	   if($this->module_right_model->validate_form_data() === TRUE){
		  
		  $module_right_id = $this->module_right_model->update_data($module_right_id);
          if($module_right_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."module_rights/edit/$module_right_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."module_rights/edit/$module_right_id");
            }
        }else{
			$this->edit($module_right_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $module_right_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($module_right_id, $page_id = NULL){
        
        $module_right_id = (int) $module_right_id;
        
		//get order number of this record
        $this_module_right_where = "module_right_id = $module_right_id";
        $this_module_right = $this->module_right_model->getBy($this_module_right_where, true);
        $this_module_right_id = $module_right_id;
        $this_module_right_order = $this_module_right->order;
        
        
        //get order number of previous record
        $previous_module_right_where = "order <= $this_module_right_order AND module_right_id != $module_right_id ORDER BY `order` DESC";
        $previous_module_right = $this->module_right_model->getBy($previous_module_right_where, true);
        $previous_module_right_id = $previous_module_right->module_right_id;
        $previous_module_right_order = $previous_module_right->order;
        
        //if this is the first element
        if(!$previous_module_right_id){
            redirect(ADMIN_DIR."module_rights/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_module_right_inputs = array(
            "order" => $previous_module_right_order
        );
        $this->module_right_model->save($this_module_right_inputs, $this_module_right_id);
        
        $previous_module_right_inputs = array(
            "order" => $this_module_right_order
        );
        $this->module_right_model->save($previous_module_right_inputs, $previous_module_right_id);
        
        
        
        redirect(ADMIN_DIR."module_rights/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $module_right_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($module_right_id, $page_id = NULL){
        
        $module_right_id = (int) $module_right_id;
        
        
        
        //get order number of this record
         $this_module_right_where = "module_right_id = $module_right_id";
        $this_module_right = $this->module_right_model->getBy($this_module_right_where, true);
        $this_module_right_id = $module_right_id;
        $this_module_right_order = $this_module_right->order;
        
        
        //get order number of next record
		
        $next_module_right_where = "order >= $this_module_right_order and module_right_id != $module_right_id ORDER BY `order` ASC";
        $next_module_right = $this->module_right_model->getBy($next_module_right_where, true);
        $next_module_right_id = $next_module_right->module_right_id;
        $next_module_right_order = $next_module_right->order;
        
        //if this is the first element
        if(!$next_module_right_id){
            redirect(ADMIN_DIR."module_rights/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_module_right_inputs = array(
            "order" => $next_module_right_order
        );
        $this->module_right_model->save($this_module_right_inputs, $this_module_right_id);
        
        $next_module_right_inputs = array(
            "order" => $this_module_right_order
        );
        $this->module_right_model->save($next_module_right_inputs, $next_module_right_id);
        
        
        
        redirect(ADMIN_DIR."module_rights/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["module_rights"] = $this->module_right_model->getBy($where, false, "module_right_id" );
				$j_array[]=array("id" => "", "value" => "module_right");
				foreach($data["module_rights"] as $module_right ){
					$j_array[]=array("id" => $module_right->module_right_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
