<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class User_m extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "users";
        $this->pk = "user_id";
        $this->status = "status";
    }
    //------------------------------------------------------
    
    
    
    /**
     * get users with inner join role and dept
     */
    public function usersDeptRole(){
        
        $this->db->select("users.*, roles.role_title, departments.department_title");
        $this->db->from($this->table);
        $this->db->join("roles", "users.role_id = roles.role_id");
        $this->db->join("departments", "users.ngo_id = departments.ngo_id");
        $query = $this->db->get();
        var_dump($query->result());
        
    }
    //---------------------------------------------------------
    
    
    
    /**
     * login a user
     */
    public function login(){
        
        
    }
    //--------------------------------------------------------
    
    
    
    
    /**
     * check if user is logged in or not
     */
    public function loggedIn(){
        
        if($this->session->userdata("logged_in") === TRUE){
            return true;
        }
        return false;
    }
    //---------------------------------------------------------
    
    
    
    /**
     * log out the user
     */
    public function logOut(){
        
        $this->session->sess_destroy();
    }
}