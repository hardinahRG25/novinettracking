<?php

require_once APPPATH . 'libraries/Ldap.php';
/**
 * Description of Login
 *
 * @author hardinah
 */
date_default_timezone_set('Africa/Nairobi');

class UserManagement extends CI_Controller
{

    const LDAP_HOST = "";
    const LDAP_PORT = 0;

    /**
     *
     * @var type UserModel
     */
    var $UserModel;
    var $userSession;
    var $userMep;
    var $UserMepModel;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("UserMepModel");
        $this->load->library('encryption');
        $this->userSession = $this->session->userdata('connecter');
        $this->userMep = $this->UserMepModel->get_where(array('ldap' => $this->userSession['login']));
    }

    function index(){
        if ($this->userSession != null) {
            redirect('calendar');
        }
        $this->login_vw();
    }

    //put your code here
    function login_vw(){
        if ($this->userSession != null) {
            redirect('dashboard');
        }
        $data = null;
        $data['title'] = "Authentification";
        $data['display_message'] = $this->session->flashdata('display_message');
        $data['username'] = $this->session->flashdata('username');
        $this->load->view('user/login_vw', $data);
    }

    function user_vw(){
        if (!$this->userSession) {
            redirect('login');
        } elseif ($this->userMep[0]['access'] != "admin") {
            redirect('dashboard');
        }
        $data['usermep'] = $this->userSession;
        $data['usermep']['access'] = $this->userMep[0]['access'];
        $data['title'] = "NoviNet| Gestion d'utilisateur";
        $this->template->build('user/user_utilities', $data);
    }

    function set_remember_me($uname, $data, $remember_me = null){
        $this->session->set_userdata($uname, $data);
        if (!$remember_me) {
            $this->session->mark_as_temp($uname, 7200);
        }
    }

    function do_login(){
        $username = isset($this->username) ? $this->username : $this->input->post('username');
        $password = isset($this->password) ? $this->password : $this->input->post('password');
        $remember_me = $this->input->post('remember_me');
        if ($remember_me == true || $remember_me == 1) {
            $remember_me = 1;
        } else {
            $remember_me = null;
        }
        $data = array(
            'mail' => $username, 
            'password' => md5($password)
        );
        try {
            $inApp = $this->UserMepModel->get_user_by_login($data);            
            if (empty($inApp)) {
                $this->handleLoginError('Utilisateur ou mot de passe invalide');
            } else {
                $this->session->set_userdata("connecter", array(
                    'login' => $inApp[0]['ldap'],
                    'id' => $inApp[0]['id'],
                    'access' => $inApp[0]['access'],
                ));
                redirect('dashboard');
            }
        } catch (Exception $exc) {
            $this->handleLoginError($exc->getMessage());
        }
    }

    function logOut(){
        $this->session->unset_userdata("connecter");
        redirect('login');
    }

    private function handleLoginError($msg){
        $this->session->set_flashdata("display_message_error", $msg);
        redirect('login');
    }
}
