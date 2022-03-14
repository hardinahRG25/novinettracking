<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Model
 *@var 
 * @author hardinah
 */
abstract class MY_Model extends CI_Model {
    /**
     *
     * @var type string table_name
     */
    var $table_name;
    /**
     *
     * @var type string pk_name , primary key for table_name
     */
    var $pk_name;
    /**
     *
     * @var _db, equals to CI_DB
     */
    var $_db;
    
    public function __construct() {
        parent::__construct();
        $this->set_table_name();
        $this->_db = $this->db;
    }
    
    public abstract function set_table_name();
    
    public abstract function set_pk_name();


    public function get($orderby = array()) {
        if(!empty($orderby)) {
            if(isset($orderby[1])) {
                $this->_db->order_by($orderby[0], $orderby[1]);
            } else {
                $this->_db->order_by($orderby[0]);
            }
        }
        $res = $this->db->get($this->table_name);
        return $res->result_array();
    }
    
    public function get_row_where($where) {
        $res = $this->db->get_where($this->table_name, $where);
        return $res->row_array();
    }
    
    public function get_where($where) {
        $res = $this->db->get_where($this->table_name, $where);
        return $res->result_array();
    }
    /**
     * add value to model
     * @param type $data
     * @return boolean
     */
    public function insert($data) {
        $res = $this->db->insert($this->table_name, $data);
        if($res) {
            return $this->db->insert_id($this->table_name);
        }
        return false;
    }
    /**
     * update model
     * @param type $data
     * @param type $where
     * @return type
     */
    public function update($data, $where) {
        return $this->db->update($this->table_name, $data, $where); 
    }
    /**
     * delete model
     * @param type $where
     * @return type
     */
    public function delete($where) {
        $this->db->where($where);
        return $this->db->delete($this->table_name);
    }
}
