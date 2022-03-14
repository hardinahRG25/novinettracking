<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ghost_helper
 *
 * @author hardinah
 */

function getArrayUnique($data){
    $array=array();
    foreach ($data as $key => $rm){
        $array[]=$rm->getCase_id();
    }
    //var_dump(array_unique($array));
    return array_unique($array);
}
function getRuleCaseArrayUnique($data){
    $array=array();
    //var_dump($data);
    foreach ($data as $key => $case){
        $array[]=$case->id;
    }
    //var_dump(array_unique($array));
    return array_unique($array);
}