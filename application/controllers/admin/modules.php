<?php

class Modules extends Admin_Controller{
    
    public function __construct(){
        
        parent::__construct();
        $this->load->model("module_m");
		//$this->output->enable_profiler(TRUE);
    }
    //------------------------------------------------------------------------
    
    
    public function index(){
        $this->controllers();
    }
    //------------------------------------------------------------------------
    
    
    /**
     * get all controllers with status in 0,1
     */
     public function controllers(){
        
        $this->data['view'] = ADMIN_DIR."modules/controllers";
        $this->data['title'] = "Controllers";
        $this->data['controllers'] = $this->module_m->getBy("status in (0,1) and module_type = 'controller'");
        
        //var_dump($this->data);
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------------------------
     
     
    /**
     * function to create a new controller
     */
     public function add_controller(){
		
        //load icons model to create a list of available icons for controller
        $this->load->model("icon_m");
        $this->data['icons'] = $this->icon_m->get();
        
        //set the validations
        $validation_config = array(
            array(
                'field' => 'module_title',
                'label' => 'Controller name',
                'rules' => 'required'
            ),
            array(
                'field' => 'module_uri',
                'label' => 'Controller URL',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run() == TRUE){
            
            $inputs = array(
                "module_title"          => $this->input->post("module_title"),
                "module_uri"            => $this->input->post("module_uri"),
                "module_desc"           => $this->input->post("module_desc"),
                "module_menu_status"    => $this->input->post("module_menu_status"),
                "module_icon"           => $this->input->post("module_icon"),
                "status"         => $this->input->post("status")
            );
            if($this->module_m->save($inputs)){
                
                $this->session->set_flashdata("msg_success", "New controller has been created successfully");
                redirect(ADMIN_DIR."modules/controllers");
            }else{
                
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect(ADMINDIR."modules/controllers");
            }
        }else{
            
			
            $this->data['view'] = ADMIN_DIR."modules/add_controller";
            $this->data['title'] = "Add new controller";
            $this->load->view(ADMIN_DIR."layout", $this->data);
        }
     }
     //----------------------------------------------------------------------------
     
     
     
     /**
     * function to edit a controller
     */
     public function edit_controller($module_id){
        
        //get this controller data to populate form
        $module_id = (int) $module_id;
        $this->data['controller'] = $this->module_m->get($module_id);
        
        
        //load icons model to create a list of available icons for controller
        $this->load->model("icon_m");
        $this->data['icons'] = $this->icon_m->get();
        
        //set the validations
        $validation_config = array(
            array(
                'field' => 'module_title',
                'label' => 'Controller name',
                'rules' => 'required'
            ),
            array(
                'field' => 'module_uri',
                'label' => 'Controller URL',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run() == TRUE){
            
            $inputs = array(
                "module_title"          => $this->input->post("module_title"),
                "module_uri"            => $this->input->post("module_uri"),
                "module_desc"            => $this->input->post("module_desc"),
                "module_menu_status"    => $this->input->post("module_menu_status"),
                "module_icon"           => $this->input->post("module_icon"),
                "status"         => $this->input->post("status")
            );
            if($this->module_m->save($inputs, $module_id)){
                
                $this->session->set_flashdata("msg_success", "Controller has been updated successfully");
                redirect(ADMIN_DIR."modules/edit_controller/".$module_id);
            }else{
                
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect(ADMINDIR."modules/edit_controller/".$module_id);
            }
        }else{
            
            $this->data['view'] = ADMIN_DIR."modules/edit_controller";
            $this->data['title'] = "Edit controller";
            $this->load->view(ADMIN_DIR."layout", $this->data);
        }
     }
     //-----------------------------------------------------------------------
     
     
     /**
      * function to view trashed controllers
      */
     public function trashed_controllers(){
        
        $this->data['view'] = ADMIN_DIR."modules/trashed_controllers";
        $this->data['title'] = "Trash";
        $this->data['controllers'] = $this->module_m->getBy("status in (2) and module_type = 'controller'");
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------------
     
     
     /**
      * function to send controller to trash
      * @param $module_id integer
      */
     public function trash_controller($module_id){
        
        $module_id = (int) $module_id;
        $this->module_m->changeStatus($module_id, "2");
        $this->session->set_flashdata("msg_success", "Controller has been trashed");
        redirect(ADMIN_DIR."modules/controllers");
     }
     //----------------------------------------------------------------------------
     
     
     
     /**
      * function to restor controller from trash
      * @param $module_id integer
      */
     public function restore_controller($module_id){
        
        $module_id = (int) $module_id;
        $this->module_m->changeStatus($module_id, "1");
        $this->session->set_flashdata("msg_success", "Controller has been trashed");
        redirect(ADMIN_DIR."modules/trashed_controllers");
     }
     //---------------------------------------------------------------------------
     
     
     /**
      * function to permanently delete controller
      * @param $module_id integer
      */
     public function delete_controller($module_id){
        
        $module_id = (int) $module_id;
        $this->module_m->changeStatus($module_id, "3");
        $this->session->set_flashdata("msg_success", "Controller has been permanently deleted!");
        redirect(ADMIN_DIR."modules/trashed_controllers");
     }
     //-------------------------------------------------------------------------------
     
     
     
    /***********************************************************************/
    /************************ Actions management ***************************/
    /***********************************************************************/
    
    /**
     * get all actions of a controller
     */
    public function actions($controller_id){
        
        $controller_id = (int) $controller_id;
        
        $this->data['controller_name'] = $this->module_m->getModuleName($controller_id);
        $this->data['controller_id'] = $controller_id;
        $this->data['view'] = ADMIN_DIR."modules/actions";
        $this->data['title'] = "Actions";
        $this->data['actions'] = $this->module_m->getBy("parent_id = '".$controller_id."' and status in (0,1)");
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //---------------------------------------------------------------------------
    
    
    
    /**
      * function to view trashed controllers
      */
     public function trashed_action($controller_id){
        
        $controller_id = (int) $controller_id;
        
        $this->data['controller_name'] = $this->module_m->getModuleName($controller_id);
        $this->data['controller_id'] = $controller_id;
        $this->data['view'] = ADMIN_DIR."modules/trashed_actions";
        $this->data['title'] = "Trash";
        $this->data['actions'] = $this->module_m->getBy("status in (2) and module_type = 'action' and parent_id = '".$controller_id."'");
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //----
    
    
    /**
     * function to send action to trash
     * @param $module_id integer
     */
    public function trash_action($module_id, $controller_id){
        
        $module_id = (int) $module_id;
        $controller_id = (int) $controller_id;
        
        $this->module_m->changeStatus($module_id, "2");
        $this->session->set_flashdata("msg_success", "Action has been trashed");
        redirect(ADMIN_DIR."modules/actions/".$controller_id);
     }
     //----------------------------------------------------------------------------
     
     
     
     /**
      * function to restor controller from trash
      * @param $module_id integer
      */
     public function restore_action($module_id, $controller_id){
        
        $module_id = (int) $module_id;
        $controller_id = (int) $controller_id;
        
        $this->module_m->changeStatus($module_id, "1");
        $this->session->set_flashdata("msg_success", "Action has been restored");
        redirect(ADMIN_DIR."modules/trashed_action/".$controller_id);
     }
     //---------------------------------------------------------------------------
     
     
     /**
      * function to permanently delete controller
      * @param $module_id integer
      */
     public function delete_action($module_id, $controller_id){
        
        $module_id = (int) $module_id;
        $controller_id = (int) $controller_id; 
        
        $this->module_m->changeStatus($module_id, "3");
        $this->session->set_flashdata("msg_success", "Action has been permanently deleted!");
        redirect(ADMIN_DIR."modules/trashed_action/".$controller_id);
     }
     //--------------------------------------------------------------------------------------
     
     
    /**
     * function to create a new controller
     */
     public function add_action($controller_id){
        
        //load icons model to create a list of available icons for controller
        $this->load->model("icon_m");
        $this->data['icons'] = $this->icon_m->get();
        
        //set the validations
        $validation_config = array(
            array(
                'field' => 'module_title',
                'label' => 'Controller name',
                'rules' => 'required'
            ),
            array(
                'field' => 'module_uri',
                'label' => 'Controller URL',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run() == TRUE){
            
            $controller_id = (int) $controller_id;
            $inputs = array(
                "module_title"          => $this->input->post("module_title"),
                "parent_id"             => $controller_id,
                "module_type"           => "action",
                "module_uri"            => $this->input->post("module_uri"),
                "module_desc"           => $this->input->post("module_desc"),
                "module_menu_status"    => $this->input->post("module_menu_status"),
                "module_icon"           => $this->input->post("module_icon"),
                "status"         => $this->input->post("status")
            );
            if($this->module_m->save($inputs)){
                
                $this->session->set_flashdata("msg_success", "New Action has been created successfully");
                redirect(ADMIN_DIR."modules/actions/".$controller_id);
            }else{
                
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect(ADMINDIR."modules/actions/".$controller_id);
            }
        }else{
            
            $this->data['controller_id'] = $controller_id;
            $this->data['view'] = ADMIN_DIR."modules/add_action";
            $this->data['title'] = "Add new action";
            $this->load->view(ADMIN_DIR."layout", $this->data);
        }
     }
     //--------------------------------------------------------------------------------------
     
     
    /**
     * function to edit action
     */
     public function edit_action($module_id, $controller_id){
        
        //get this controller data to populate form
        $module_id = (int) $module_id;
        $this->data['action'] = $this->module_m->get($module_id);
        
        //load icons model to create a list of available icons for controller
        $this->load->model("icon_m");
        $this->data['icons'] = $this->icon_m->get();
        
        //set the validations
        $validation_config = array(
            array(
                'field' => 'module_title',
                'label' => 'Controller name',
                'rules' => 'required'
            ),
            array(
                'field' => 'module_uri',
                'label' => 'Controller URL',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run() == TRUE){
            
            $controller_id = (int) $controller_id;
            $inputs = array(
                "module_title"          => $this->input->post("module_title"),
                "parent_id"             => $controller_id,
                "module_type"           => "action",
                "module_uri"            => $this->input->post("module_uri"),
                "module_desc"           => $this->input->post("module_desc"),
                "module_menu_status"    => $this->input->post("module_menu_status"),
                "module_icon"           => $this->input->post("module_icon"),
                "status"                => $this->input->post("status")
            );
            if($this->module_m->save($inputs, $module_id)){
                
                $this->session->set_flashdata("msg_success", "Action has been updated successfully");
                redirect(ADMIN_DIR."modules/edit_action/".$module_id."/".$controller_id);
            }else{
                
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect(ADMINDIR."modules/edit_action/".$module_id."/".$controller_id);
            }
        }else{
            
            $this->data['controller_id'] = $controller_id;
            $this->data['module_id'] = $module_id;
            $this->data['view'] = ADMIN_DIR."modules/edit_action";
            $this->data['title'] = "Edit action";
            $this->load->view(ADMIN_DIR."layout", $this->data);
        }
     }
     //----------------------------------------------------------------------------
     
     
     
     
}