<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserMepModel
 *
 * @author hardinah
 */
class NetworkModel extends MY_Model {

//put your code here
    public function set_pk_name() {
        $this->pk_name = "id";
    }

    public function set_table_name() {
        $this->table_name = "network";
    }

    /**
     * get network list in table 
     * @var order 
     * @var limit 
     */

    public function get_network_data($order,$limit, $where = null) {
        $this->_db->select("{$this->table_name}.*");
        $this->_db->from($this->table_name);
        if($where != null){
            $this->_db->where($where);
        }
        if($order != null){
            $this->_db->order_by("create", $order);
        }
        if($limit != null){
            $this->_db->limit($limit);
        }        
        return $this->_db->get()->result_array();
    }

    public function get_network_avg($select, $where = null) {
        $this->_db->select($select);
        $this->_db->from($this->table_name);
        if($where != null){
            $this->_db->where($where);
        }
        //echo $this->_db->get_compiled_select();die;      
        return $this->_db->get()->result_array();
    }
}
