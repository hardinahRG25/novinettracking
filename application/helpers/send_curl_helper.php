<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('send_cUrl')) {

    function send_cUrl($url, $headers, $method, $data)
    {

        if (empty($headers)) {
            $headers = array(
                "Content-Type: application/json; charset=utf-8"
            );
        }
        // get main CodeIgniter object
        $ci = get_instance();
        // Write your logic as per requirement
        $parameter = ($data && !empty($data)) ? http_build_query($data) : "";
        $headers[] = "Content-Length: " . strlen(json_encode($data));
        if ($method == 'GET') {
            $url = $url . '?' . $parameter;
        }
        $curl = curl_init($url);
        /*curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__) . "/cacert.pem");
        if (strtoupper($method) == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $parameter);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }*/

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        if ($method != "GET")
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__) . "/cacert.pem");
        $result = curl_exec($curl);

        $error = curl_error($curl);
        $error_no = curl_errno($curl);

        curl_close($curl);

        if (!$result) {
            return array("error_message" => 'message: "' . $error . '" - error_code: ' . $error_no, "failed" => true);
        } else {
            return $result;
        }
    }
}
