<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Icon_m extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "icons";
        $this->pk = "icon_id";
        $this->status = "";
    }
}