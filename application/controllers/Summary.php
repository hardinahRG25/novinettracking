<?php

/**
 *
 * @author hardinah
 */
date_default_timezone_set('Africa/Nairobi');

class Summary extends CI_Controller {

    public $error = null;

    /**
     *
     * @var type 
     */
    var $UserMepModel;
    var $userSession;
    var $userMep;

    function __construct() {
        parent::__construct();
        $this->load->model('UserMepModel');
        $this->userSession = $this->session->userdata('connecter');
        $this->userMep = $this->UserMepModel->get_where(array('ldap' => $this->userSession['login']));
    }

    function index() {
        
    }

    function dashboardView() {
        if ($this->userSession == null) {
            redirect('login');
        }
        $data['usermep'] = $this->userSession;
        if (count($this->userMep) > 0) {
            $data['usermep']['access'] = $this->userMep[0]['access'];
        } else {
            $data['usermep']['access'] = "actor";
        }
        $data['title'] = "NoviNet | Dashboard";
        $this->template->build('dashboard/SummaryDashboard', $data);
    }

}
