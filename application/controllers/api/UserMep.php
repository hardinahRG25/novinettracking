<?php

date_default_timezone_set('Africa/Nairobi');
require(APPPATH . '/libraries/REST_Controller.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of noviNet
 *
 * @author hardinah
 */
class UserMep extends REST_Controller
{

    //put your code here
    /**
     *
     * @var type MepModel
     */
    var $UserMepModel;

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        if ($this->session->userdata("connecter") == null) {
            $this->response(array("status" => "Not connected"), REST_Controller::HTTP_FORBIDDEN);
            return;
        }
        $this->load->model('UserMepModel');
        $this->load->library('encryption');
    }

    public function usermeps_get()
    {
        $res = $this->UserMepModel->get_usermep();
        $this->response($res);
    }

    public function usermep_by_access_get()
    {
        $access = array('access' => $this->get('access'));
        $res = $this->UserMepModel->get_where($access);
        $this->response($res);
    }

    public function usermep_get($id=null)
    {
        $res = null;
        if ($id) {
            $res = $this->UserMepModel->get_where(array('id' => $id));
        }
        $this->response($res);
    }

    public function userApp_get()
    {
        $res = $this->UserMepModel->get_where(array('ldap' => $this->get('ldap')));
        $this->response($res);
    }

    public function usermep_put()
    {
        $id = $this->put("id");
        $ldap = $this->put("ldap");

        $data = array(
            "name" => $this->put("name"),
            "first_name" => $this->put("first_name"),
            'ldap' => $this->put("ldap"),
            "mail" => $this->put("mail"),
            "tel" => $this->put("tel"),
            'profil' => null,
            'access' => $this->put("access"),
            "password" => md5($this->put("pass"))
        );
        if (!$id) {
            $test_exist = $this->UserMepModel->get_where("UPPER(ldap)=UPPER('$ldap')");
            if (!$test_exist || count($test_exist) <= 0) {
                $res = $this->UserMepModel->insert($data);
            } else {
                $res = array('error' => true, 'error_message' => 'login utilisateur déjà utilisé');
            }
        } else {
            $res = $this->UserMepModel->update($data, array("id" => $id));
        }
        $return  = [
            'success' => [
                'insert'=>[
                    "number"=>$res
                ],
                'request' => md5($this->fcnt_uuid())
            ]
        ];
        $this->response($return);
    }

    public function usermep_delete($id)
    {
        $res = 0;
        if ($id) {
            $res = $this->UserMepModel->delete(array("id" => $id));
        }
        return $this->response($res);
    }

    private function fcnt_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}
