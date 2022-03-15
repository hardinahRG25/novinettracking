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
class NetworkTracking extends REST_Controller {

    //put your code here
    /**
     *
     * @var type MepModel
     */
    var $networkModel;

    public function __construct($config = 'rest') {
        parent::__construct($config);
        if ($this->session->userdata("connecter") == null) {
            $this->response(array("status" => "Not connected"), REST_Controller::HTTP_FORBIDDEN);
            return;
        }
        $this->id = $this->session->userdata("connecter")['id'];
        $this->username = $this->session->userdata("connecter")['login'];
        $this->access = $this->session->userdata("connecter")['access'];
        $this->data72hours = $this->defaultTime('72');        
        $this->load->model('UserMepModel');
        $this->load->model('NetworkModel');
        $this->load->library('encryption');
    }

    public function index_get() {
        $this->response($this->session->userdata("connecter"));
    }

    


    public function dataNetwork_get($id) {
        $user = $this->UserMepModel->get_where(array('ldap' => $this->get('ldap')));
        $res = null;
        if ($id) {
            $res = $this->NetworkModel->get_where(array('id' => $id));
        }
        $this->response($res);
    }

    public function dataNetwork_by_user_get() {
        $res = $this->NetworkModel->get_where(array('ldap' => $this->get('ldap')));
        $this->response($res);
    }

    public function dataNetwork_put() {
        $uuid = $this->fcnt_uuid();
        $user_id = $this->put("userId");
        $user_ip = $this->put("adressIp") ?? '';
        $effecive_network_type = $this->put("effecive_network_type") ?? 'Unknown';
        $current_download_speed = $this->put("current_download_speed") ?? 0;
        $round_trip_time = $this->put("round_trip_time") ?? 0;
        $data = $this->put("data") ?? '';
        $speed = $this->put("userSpeed") ?? 0;

        $data = array(
            "uuid" => $uuid
            , "user_id" => $user_id
            , 'user_ip' => $user_ip
            , "effecive_network_type" => $effecive_network_type
            , "current_download_speed" => $current_download_speed
            , 'round_trip_time' => $round_trip_time
            , 'data' => $data
            , 'speed' => $speed
            ,'uuid_date' =>date('YmdH'));
        $res = $this->NetworkModel->insert($data);
        $this->response($res);
    }
    
    /**
     * DATA NETWORK
     */ 
        //Get data network
            /**
             * 
             */
            public function userDataHistory_get() {  
                $res = $this->refactorScript();
                foreach ($res['success']['list'] as $key => $value) {
                    $user = $this->UserMepModel->get_user_by_login(array('id'=>$res['success']['list'][$key]['user_id']));
                    $res['success']['list'][$key]['livrable_source'] = $user[0]['ldap'];
                }
                $this->response($res['success']['list']);  
            }
        //Get number of repartition type
            /**
             * @param integer 0 or 1
             * @return array
             */
            public function repartitionNetworkType_get() {
                $res = $this->refactorScript();
                return $this->response(array(
                    'count' => [
                        $res['success']['statistics']['3G'],
                        $res['success']['statistics']['4G'],
                        $res['success']['statistics']['OTHER']
                    ], 
                    'label' => [
                        '3G',
                        '4G',
                        'AUTRE']
                ));
            }
        //NetworkTracking.php
            /**
             * 
             */
            private function refactorScript(){
                $date_start = $this->get('start');   
                $date_end = $this->get('end');
                return $this->primaryAccess('DESC',$this->get('all'),$date_start,$date_end,$this->get('user_id'));
            }
        //Get line chart
            /**
             * 
             */
            public function my_info_get(){
                $bgColor = ["#36CD3196","#78DCFE","#541a38","#EF58A8","#F69243","#95B0EA","#521726","#2fe7cf","#3aa264","#d33e7f","#0caac9","#fdf53a","#293579","#8fbec0","#fd154a","#9ec0d5","#cac8d1","#d8af14","#54ea20","#71e910","#020876","#b56549","#bb2370","#1ab489","#6fc867","#58f1a5","#95e8f8","#f7095c","#1b21f5","#4d58cb","#665efd","#1d68ca","#9f1dbd","#8165e1","#a1b634","#f9875f","#8e6ea8","#ee43e3","#c7f4d6","#19aaaf","#6f5284","#c0a6be","#982890","#d35d1f","#0e7b34","#1dedef","#fa0707","#c34174","#db97c7","#947e10","#7c641b","#49fe21","#293c8e","#a73fec","#e800f9","#12878b","#56d434","#b70a05","#d88c40","#f43452","#ace140","#516ef1","#73cd6b","#1a999f","#bfb530","#a73cb5","#a6b747","#7a503c","#a9fe85","#d5e2c8","#f23185","#b27958","#0de5d6","#99b91f","#b55f91","#db8f93","#df0e4e","#1e7ba1","#e5189c","#f5cacf","#0b11c7","#7cf139","#3a45b9","#617197","#93ffc7","#f21ec3","#fc31d5","#10fd3d","#78cff4","#0d9fdc","#184b45","#fee33a","#d590a5","#10f095","#57359a","#c3dd3b","#0d603f","#d40c5c","#45f82f","#005996"];
                $params = array(
                    "start"=>$this->get('start'),
                    "end"=>$this->get('end'),
                    "search_detail"=>$this->get('search_detail'),
                    "user_id"=>$this->get('user_id') ?? null
                );
                $datetest = $this->getDatesFromRange($params['start'],$params['end']);
                $title = 'Moyenne de vitesse internet par jour et par collaborateur (Mbps)';
                if($this->access != 'admin'){
                    if($params['search_detail'] === 'avg'){
                        for ($i=0; $i <count($datetest); $i++) { 
                            $valueUser[] = $this->getDataUserAvg($this->id,$datetest[$i]);
                       }
                        $title = 'Moyenne de vitesse internet par jour (Mbps)';
                    }else{
                        $title = 'Affichage des test internet par heure(Mbps)';
                        $res = $this->getDataUserTime($this->id,$params['start'],$params['end']);
                        $valueUser = $res['data'];
                        $datetest = $res['labels'];
                    }
                    $datasets[] = array(
                        'label' => $this->username,
                        'data'=> $valueUser,
                        'backgroundColor'=>'rgba(96, 168, 113, 0.7)',
                        'borderColor'=>'rgba(144,238,137,1)',
                        'borderWidth'=>1,
                        'fill'=>true
                    );
                }else{
                    if($params['user_id'] && $params['user_id'] != null){
                        $user = $this->UserMepModel->get_user_by_login(array('id'=>$params['user_id']));
                        $this->username = $user[0]['ldap'];
                        if($params['search_detail'] == 'avg'){
                            $title = 'Moyenne de vitesse internet par jour (Mbps)';
                            for ($i=0; $i <count($datetest); $i++) { 
                                $valueUser[] = $this->getDataUserAvg($params['user_id'],$datetest[$i]);
                            }
                        }else{
                            $title = 'Test vitesse internet par jour (Mbps)';
                            $res = $this->getDataUserTime($params['user_id'],$params['start'],$params['end']);
                            $valueUser = $res['data'];
                            $datetest = $res['labels'];
                        }
                        $datasets[] = array(
                            'label' => $this->username,
                            'data'=> $valueUser,
                            'backgroundColor'=>'rgba(96, 168, 113, 0.7)',
                            'borderColor'=>'rgba(144,238,137,1)',
                            'borderWidth'=>1,
                            'fill'=>true
                           );
                    }else{
                        $listUser = $this->UserMepModel->get_usermep();
                        if($params['search_detail'] === 'avg'){
                            for ($i=0; $i <count($listUser); $i++) { 
                                for ($d=0; $d <count($datetest) ; $d++) { 
                                    $valueUser[$i][] = $this->getDataUserAvg($listUser[$i]['id'],$datetest[$d]);
                                }
                                $datasets[$i] = array(
                                    'label' => $listUser[$i]['ldap'],
                                    'data'=> $valueUser[$i],
                                    'borderColor'=>$bgColor[$i],
                                    'backgroundColor'=>$bgColor[$i],
                                    'borderWidth'=>1,
                                    'fill'=>true
                                   );
                            }
                        }
                        
                    }                    
                }
                
                $return = [
                        'success'=> [
                            'labels' => $datetest,
                            'datasets' => $datasets,
                            'title' => $title
                        ]
                    ];
                $this->response($return);
            }
            /**
             * @params integer id
             * @params date date
             */
            public function getDataUserAvg($id,$date){
                $array = "";
                $array .= " user_id = '".$id."' ";
                $array .= " AND DATE(network.create) = '".$date."' ";
                $res = $this->NetworkModel->get_network_avg(' AVG(network.speed) AS speedAvg',$array);
                $valueSpeed = 0;
                if(!empty($res)){
                    $valueSpeed = floatval($res[0]['speedAvg']);
                }
                return $valueSpeed;
            }

            public function getDataUserTime($id,$start,$end){
                $array = "";
                $array .= " user_id = '".$id."' ";
                $array .= " AND DATE(network.create) >= '".$start."' ";
                $array .= " AND DATE(network.create) <= '".$end."' ";
                $res = $this->NetworkModel->get_network_avg(' * ',$array);
                $label = array();
                $data = array();
                if(!empty($res)){
                    for ($i=0; $i < count($res); $i++) { 
                        $label[$i] = $res[$i]['create'];
                        $data[$i] = $res[$i]['speed'];
                    }
                }
                return $res = [
                    'labels' => $label,
                    'data' => $data
                ];
            }
            
        //List of network
            /**
             * @var order : string, "ASC" or "DESC"
             * @var limit : integer, limit of line request
             * @var where : array or string sql syntaxes
             * @return array or null
             */
            private function getNetworkTrackList($order,$limit,$where = null){
                $data = $this->NetworkModel->get_network_data($order,$limit,$where);
                $count3g =  0;
                $count4g =  0;
                $label = [];
                $valueTime = [];
                foreach ($data as $key => $value) {
                    if($data[$key]['effecive_network_type'] == '3g'){
                        $count3g++;
                    }
                    if($data[$key]['effecive_network_type'] == '4g'){
                        $count4g++;
                    }
                    $t = explode(' ',$data[$key]['create']);
                    $t = explode(':',$t[1]);
                    $time = $t[0].":".$t[1];
                    $valueTime[] = $data[$key]['speed'];
                    $label[] = $time;
                }
                $return = [
                    'success' => [
                        'list'=> $data,
                        'statistics' => [
                                '3G' => $count3g,
                                '4G' => $count4g,
                                'OTHER' => count($data)-($count3g+$count4g)
                            ],
                        'lineInfo' => [
                                'label' => $label,
                                'value' => $valueTime
                            ]
                        ]
                    ];
                return $return;
            }
    /**
     * USER INFORMATIONS
     */
        //Information about a specific user
            /**
             * @param username
             * @return array
             */
            public function userFullInforamtion($username){
                $userData = $this->UserMepModel->get_where(array('ldap' => $username));
                if(!empty($userData)){
                    return $userData[0];
                }
                return false; 
            }
        //Get last insert
            /**
             * 
             */
            public function lastInsert_get() {
                $userAccount = $this->UserMepModel->get_where(array('ldap' => $this->get('ldap')));
                $where = array("user_id"=>$userAccount[0]['id']);
                $res = $this->getNetworkTrackList('desc',100,$where);
                $value = false;
                $diff_date = 0;
                if(!empty($res['success']['list'])){
                    $diff_date = strtotime(date("Y-m-d H:i:s")) -  strtotime($res['success']['list'][0]['create']);
                    if($diff_date>10800){
                        $value = true;
                    }
                }else{
                    $value = true;
                }		
                $return = [
                    'success' => [
                        'insert'=> $value,
                        'date' => $res['success']['list'][0]['create'] ?? null
                        ]
                    ];
                $this->response($return);
            }
    /**
     * BASICAL FUNCTION 
     * 
     */
        //change default date for get data
        /**
         * @var hour : integer hour value
         * @return date format yyyy-m-d H:i:s;
         */
        private function defaultTime($hours){
            return $date_specified = date("Y-m-d H:i:s", strtotime("-".$hours." hours", strtotime(date("Y/m/d H:i:s",  strtotime(date("Y/m/d H:i:s"))))));
        }

        //Generate uuid code
            /**
             * @return varchar (number : 36)
             */
            private function fcnt_uuid() {
                return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                    mt_rand( 0, 0xffff ),
                    mt_rand( 0, 0x0fff ) | 0x4000,
                    mt_rand( 0, 0x3fff ) | 0x8000,
                    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
                );
            }

        //Sql condition
            /**
             * @param integer request data, only the user connected or all
             * @return string 
             */
            private function ownData($visibility,$start,$end,$user = null){
                $sqlReturn = "1=1";
                $sqlReturn .= " AND create >= '".$start."'";
                $sqlReturn .= " AND create <= '".$end."'";
                if(intval($visibility) == 0){
                    $userInfo = $this->userFullInforamtion($this->session->userdata("connecter")['login']);
                    $sqlReturn .= "AND user_id = '".$userInfo['id']."'";
                    
                }else{
                    if($user && $user != null){
                        $sqlReturn .= "AND user_id = '".$user."'"; 
                    }
                }                
                return $sqlReturn;
            }
        //primary access
            /**
             * @params integer for have information if an ID or ALL
             * @params order : string 
             * @return array
             */
                private function primaryAccess($order,$visibility,$start,$end,$user_id = null){
                    if($order == null){
                        $order = 'DESC';
                    }
                    $where = $this->ownData($visibility,$start,$end,$user_id);
                    return $res = $this->getNetworkTrackList($order,'100',$where);
                }
        //Random color
                /**
                 * @return varchar color
                 */
                private function random_hex_color() {
                    $r = rand(0, 255);
                    $g = rand(0, 255);
                    $b = rand(0, 255);
                    return sprintf('#%02x%02x%02x', $r, $g, $b);
                }
                private function random_rgb_color() {
                    $r = rand(0, 255);
                    $g = rand(0, 255);
                    $b = rand(0, 255);
                    return "rgb($r, $g, $b)";
                }
        //Get all date between two date
                /**
                 * 
                 */                  
                // Function to get all the dates in given range
                private function getDatesFromRange($start, $end, $format = 'Y-m-d') {
                      
                    // Declare an empty array
                    $array = array();
                      
                    // Variable that store the date interval
                    // of period 1 day
                    $interval = new DateInterval('P1D');
                  
                    $realEnd = new DateTime($end);
                    $realEnd->add($interval);
                  
                    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
                  
                    // Use loop to store date into array
                    foreach($period as $date) {                 
                        $array[] = $date->format($format); 
                    }
                  
                    // Return the array elements
                    return $array;
                }
    }
