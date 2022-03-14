<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('create_log')) {

    function create_log($stCurLogFileName, $arMsg) {
        $path = FCPATH;
        $path = str_replace('\\', "/", $path);
        $log_path = $path . "log/";
        $stEntry = "";
        $arLogData['event_datetime'] = '[' . date('D Y-m-d H:i:s') . '] [' . $_SERVER['REMOTE_ADDR'] . ']';
        if (is_array($arMsg)) {
            foreach ($arMsg as $msg)
                $stEntry .= $arLogData['event_datetime'] . " " . $msg . "\r\n";
        } else {
            $stEntry .= $arLogData['event_datetime'] . " " . $arMsg . "\r\n";
        }
        $fHandler = fopen($log_path . $stCurLogFileName, 'a+');
        fwrite($fHandler, $stEntry);
        fclose($fHandler);
    }

}
