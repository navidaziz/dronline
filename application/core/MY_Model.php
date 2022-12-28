<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model{
    
    public $table;
    public $pk;
    public $status;
    public $per_page;
    public $uri_segment;
    
    public function __construct(){
        
        parent::__construct();
        $this->per_page = 10;
        //$this->uri_segment =  $this->uri->segment(2);
    }
    
    
    public function get($id = NULL){
        
        if($id != NULL){
            $this->db->where($this->pk, $id);
            $query = $this->db->get($this->table);
            return $query->row();
        }else{
            $query = $this->db->get($this->table);
            return $query->result();
        }
    }
	
	 public function getTotal($table, $conditions){
		 
		 $this->db->from($table);
		 $this->db->where($conditions);
		 return $this->db->count_all_results();
		 
        
    }
	
	   /* run a custom query */
    public function runQuery($query){
        $query= $this->db->query($query);
        return $query->result();
    }
    //-------------------------------------------------
	
    
    
   public function getBy($where, $single = false, $cols= null, $order_by=false){
			 if($cols == null){
				$this->db->select("*");
			}else{
				$this->db->select($cols);
			}
			
			$this->db->where($where);
			if($single != false){
				$this->db->limit(1);
				$query = $this->db->get($this->table);
				return $query->row();
			}
			
			//order by 
			if($order_by != false){
				//var_dump($order_by);
				$this->db->order_by($order_by);
				
			}
			
			$query = $this->db->get($this->table);
			return $query->result();

    }
    //-----------------------------------------------------------
    
    
    
    
    /**
     * function to get a joined data from multiple tables
     * @param $fields array an array of fields to be selected from database
     * with table names as prefix e.g. users.user_name, users.user_id, roles.role_id
     * @param $table string parent table name
     * @param $join_table array of tables to be joined, name of table as index and
     * condition for joining as value
     * @param $where if the where condition is not null, apply it
     * @param $return_count if we want cout of all records instead of the records, make it true
     * @param $single if songle is set to true, the where condition will be applied and pagination
     * will be disabled. $where must also be set to return the single record
     * @return $data joined data
     */
    public function joinGet($fields, 
							$table, 
							$join_table, 
							$where = FALSE, 
							$return_count = FALSE, 
							$single = FALSE, 
							$order_by=FALSE, 
							$limit=FALSE,
							$group_by=FALSE, 
							$joins='inner'){
        
        //process the fields
        $fields_str = "";
        if(is_array($fields)){
            $fields_str = implode(", ", $fields);
        }else{
            $fields_str = $fields;
        }
        //select statement
        $this->db->select($fields_str);
        
        //parent table
        $this->db->from($table);
        
        //process the join
		if($join_table){
        foreach($join_table as $table_name => $condition){
            $this->db->join($table_name, $condition, $joins);
        }
		}
        
        //add the condition
        if($where != FALSE){
            $this->db->where($where);
        }
		
		//order by 
		if($order_by != FALSE){
            $this->db->order_by($order_by);
        }
		
		if($limit != FALSE){
			
            $this->db->limit($limit);
        }
		if($group_by != FALSE){
		$this->db->group_by($group_by);
		}
        
        //if we want count of record then return the count
        if($return_count != FALSE){
            return $this->db->count_all_results();
        }else{
            
            //by default all record with pagination enabled will be return
            if($single != FALSE){
                //but disable the pagination for single record returing
                $query = $this->db->get();
                return $query->result();
            }else{
                //do the query
				
                $this->db->limit($this->per_page, $this->uri_segment);
                $query = $this->db->get();
				
                return $query->result();
            }
        }
        
        
        
    }
    //-------------------------------------------------------
    
    
    
    /**
     * function to insert new data to a table
     * if $id is provieded it will edit that recored
     * @param $data array of field values pair
     * @param $id integer id of the record
     */
    public function save($data, $id = NULL){
        
        if($id != NULL){
            $this->db->set($data);
            $this->db->where($this->pk, $id);
            $this->db->update($this->table);
        }else{
            $this->db->set($data);
            $this->db->insert($this->table);
            $id = $this->db->insert_id();
			//update order .........
			$this->db->set(array("order" => $id ));
			$this->db->where($this->pk, $id);
            $this->db->update($this->table);
			
        }
        return $id;
    }
    //----------------------------------------------------
    
    
    
    /**
     * function to change status of a recored
     * @param $id integer id of the record
     * @param $status integer status of the recored
     */
    public function changeStatus($id, $status = "1"){
        
        if(!$id){
            return false;
        }
        $this->db->set(array($this->status => $status));
        $this->db->where($this->pk, $id);
        $this->db->update($this->table);
        return $id;
    }
    //-------------------------------------------------------
    
    
	public function delete($condition){
        
        if(!$condition){
            return false;
        }
       
	    $this->db->where($condition);
        $this->db->delete($this->table);
        return true;
    }
	
    
    /**
     * function to get a specific column from a table
     * @param $col string column name
     * @param $id integer id of the record
     * @return $col_val mixed value of the column
     */
    public function getCol($col, $id){
        
        $id = (int) $id;
        $this->db->select($col);
        $this->db->from($this->table);
        $this->db->where($this->pk, $id);
        $this->db->limit(1);
        $query = $this->db->get();
        $obj = $query->row();
        return $obj->$col;
    }
    //-----------------------------------------------------
    
    
    
    
    /**
     * get array of 
     */
    public function getList($relation_table_name, $relation_primary_key, $relation_dd_column, $condition = NULL, $order=NULL){
        
        $this->db->select(array($relation_primary_key, $relation_dd_column));
        $this->db->from($relation_table_name);
        if($condition != NULL){
            $this->db->where($condition);
        }else{
			$this->db->where(array("status" => 1));
			}
		if($order != NULL){
            $this->db->order_by($order);
        }	
        $query = $this->db->get();
        $results = $query->result();
        
        $dd_array = array();
        foreach($results as $result){
            $dd_array[$result->$relation_primary_key] = $result->$relation_dd_column;
        }
        return $dd_array;
    }
	
	public function delete_file($file_path){
		
		$path_parts = pathinfo($file_path);
						$orginal_file = FCPATH."assets/uploads/".$file_path;
						$thumb_file = FCPATH."assets/uploads/".$path_parts['dirname']."/".$path_parts['filename']."_thumb.".$path_parts['extension'];
						unlink($orginal_file);
						unlink($thumb_file);
		return true;				
		
		}
	
    
    
    
}