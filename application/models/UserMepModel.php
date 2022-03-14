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
class UserMepModel extends MY_Model {

//put your code here
    public function set_pk_name() {
        $this->pk_name = "id";
    }

    public function set_table_name() {
        $this->table_name = "user";
    }

    public function get_usermep() {
        $this->_db->select("{$this->table_name}.*");
        $this->_db->from($this->table_name);
        $this->_db->order_by("ldap", "asc");
        return $this->_db->get()->result_array();
    }

    public function get_user_by_login($login_array) {
        $this->_db->select("{$this->table_name}.*");
        $this->_db->from($this->table_name);
        $this->_db->where($login_array);
        return $this->_db->get()->result_array();
    }

    public function listInterim($where) {
        $this->_db->select("{$this->table_name}.*");
        $this->_db->from($this->table_name);
        $this->_db->where($where);
        return $this->_db->get()->result_array();
    }

}
