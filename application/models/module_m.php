<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Module_m extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "modules";
        $this->pk = "module_id";
        $this->status = "status";
    }
    //---------------------------------------------------------
    
    
    /**
     * function to get module name by its ID
     * @param $module_id integer
     * @return string
     */
    public function getModuleName($module_id){
        
        $module_id = (int) $module_id;
        $this->db->select("module_title");
        $this->db->from($this->table);
        $this->db->where($this->pk, $module_id);
        $query = $this->db->get();
        $obj = $query->result();
        return $obj[0]->module_title;        
    }
    //-----------------------------------------------------------
    
    
    
    /**
     * function to get modules and combine them uder their respective controllers
     * @param $controller_id integer
     * @return $modules array of modules
     */
    public function modulesTree($controller_id = 0){
        
        $controller_id = (int) $controller_id;
        
        //first lets get all controller if controller id is not equal to 0
        $this->db->select("module_id, module_title, module_uri");
        $this->db->from($this->table);
        if($controller_id == 0){
            $this->db->where("module_type = 'controller' and status != 3");
        }else{
            $this->db->where("module_type = 'controller' and status != 3 and module_id = ".$controller_id);
        }
        $query = $this->db->get();
        $controllers = $query->result();
        
        $module_tree = array();
        foreach($controllers as $controller){
            
            //get all actions of this controller
            $this->db->select("module_id, module_title, module_uri");
            $this->db->from($this->table);
            $this->db->where("module_type = 'action' and status != 3 and parent_id = ".$controller->module_id."");
            $query_actions = $this->db->get();
            $actions = $query_actions->result();
            
            //create an array of actions
            $actions_array = array();
            foreach($actions as $action){
                 $actions_array[$action->module_id] = array($controller->module_uri."/".$action->module_uri, $action->module_title);
            }
            
            //combine both arrays
            $module_tree[$controller->module_id][$controller->module_title] = $actions_array;
        }
        return $module_tree;
        
    }
    //-----------------------------------------------------------
    
    
    
    
    /**
     * function to get module parent and prepare an array with unique module ids i.e
     * remove the repeated id. this function is used to get controller ids of the 
     * selected action ids while assigning rights to a rol
     * @param $module_ids array
     * @return $compiled_array array compiled array of modules ids
     */
    public function compileModuleIds($module_ids){
        
        $compiled_array = array();
        foreach($module_ids as $module_id){
            
            $compiled_array[] = (int) $module_id;
            $this_parent = (int) $this->getParentModule($module_id);
            if($this_parent != 0){
                $compiled_array[] = $this_parent;
            }
            
        }
        return array_unique($compiled_array);
    }
    //-------------------------------------------------------------------
    
    
    
    /**
     * function to get the parent module id of current module
     * @param $module_id integer
     * @return $parent_id integer
     */
    public function getParentModule($module_id){
        
        $module_id = (int) $module_id;
        $this->db->select("parent_id");
        $this->db->from($this->table);
        $this->db->where(array($this->pk => $module_id));
        $query = $this->db->get();
        $object = $query->result();
        $parent_id = "";
        foreach($object as $obj){
            $parent_id = $obj->parent_id;
        }
        return $parent_id;
    }
    //------------------------------------------------------------------
    
    
    
    
    public function actionIdFromName($controller_name, $action_name){
       
        $this->db->select("module_id");
        $this->db->from($this->table);
        $this->db->where("module_uri", $controller_name);
        $this->db->limit(1);
        $con_query = $this->db->get();
        $cont_obj = $con_query->row();
		
		if($cont_obj){
        $controller_id = $cont_obj->module_id;
		}else{
			$controller_id=0;
			}
        
        //now get this action of this controller
        $this->db->select("module_id");
        $this->db->from($this->table);
        $this->db->where(array(
            "module_uri" => $action_name,
            "parent_id"  => $controller_id
        ));
        $this->db->limit(1);
        $action_query = $this->db->get();
        $act_obj = $action_query->row();
		if($act_obj){
        return $act_obj->module_id;
		}else{
			return false;
			}
    }
    
    
    public function allowed_module_id($controller_name){
		$this->db->select("module_id");
        $this->db->from($this->table);
        $this->db->where("module_uri", $this->controller_name);
        $this->db->limit(1);
        $con_query = $this->db->get();
        $cont_obj = $con_query->row();
		//var_dump($cont_obj);
		if($cont_obj){
        return $cont_obj->module_id;
		}else{
			return false;
			}
		
		}
    
    
}