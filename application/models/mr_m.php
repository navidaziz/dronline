<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Mr_m extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "module_rights";
        $this->pk = "module_rights_id";
        $this->status = "status";
    }
    //-----------------------------------------------------------
    
    
    
    /**
     * function to delete all rights of a role from role id
     * @param $role_id integer
     * @return voide
     */
    public function deleteRights($role_id){
        
        $role_id = (int) $role_id;
        $this->db->delete("module_rights", array("role_id" => $role_id));
        return true;
        
    }
    //-------------------------------------------------------------
    
    
    /**
     * function to add rights for a role
     * @param $role_id
     * @param $module_ids
     * @return voide
     */
    public function addRights($role_id, $module_ids){
        
        $role_id = (int) $role_id;
        foreach($module_ids as $module_id){
            $data = array(
                "role_id"   =>  $role_id,
                "module_id" =>  $module_id
            );
            $this->db->insert($this->table, $data);
        }
         return true;
        
        
    }
    //----------------------------------------------------------------
    
    
    
    /**
     * function to get all module assigned to a role
     * @param $role_id integer
     * @return $rights array
     */
    public function rightsByRole($role_id){
        
        $role_id = (int) $role_id;
        $this->db->select("module_id");
        $this->db->from($this->table);
        $this->db->where("role_id", $role_id);
        $query = $this->db->get();
        $res = $query->result();
        
        $modules = array();
        foreach($res as $obj){
            $modules[] = $obj->module_id;
        }
        return $modules;
    }
    //-------------------------------------------------------------
    
    
    
    
    /**
     * function to get menu based on role_id
     * @param $role_id integer role id
     * @return $menu array
     */
    public function roleMenu($role_id){
        
        $role_id = (int) $role_id;
        
        $this->db->select("modules.module_id, modules.module_title, modules.parent_id, modules.module_uri, modules.module_icon");
        $this->db->from("modules");
        $this->db->join("module_rights", "modules.module_id = module_rights.module_id", "inner");
        $this->db->where("module_rights.role_id = ".$role_id." and modules.module_menu_status = 1 and modules.status = 1 and modules.parent_id = 0");
		$this->db->order_by('order', 'ASC');
        $query = $this->db->get();
        $controllers = $query->result();
        
        $menu = array();
        foreach($controllers as $controller){
            
            //$menu[$controller->module_id] = array();
            $menu[$controller->module_id]["controller_title"] = $controller->module_title;
            $menu[$controller->module_id]["controller_uri"] = $controller->module_uri;
            $menu[$controller->module_id]["controller_icon"] = $controller->module_icon;
            
            $this->db->select("modules.module_id, modules.module_title, modules.parent_id, modules.module_uri, modules.module_icon");
            $this->db->from("modules");
            $this->db->join("module_rights", "modules.module_id = module_rights.module_id", "inner");
            $this->db->where("module_rights.role_id = ".$role_id." and modules.module_menu_status = 1 and modules.status = 1 and modules.parent_id = ".$controller->module_id);
            $act_query = $this->db->get();
            $actions = $act_query->result();
            foreach($actions as $action){
                $menu[$controller->module_id]["actions"][] = array(
                    "action_title"      =>  $action->module_title,
                    "action_uri"        =>  $action->module_uri,
                    "action_id"         =>  $action->module_id
                );
            }
        }
        return $menu;
    }
    
    
    
    
}