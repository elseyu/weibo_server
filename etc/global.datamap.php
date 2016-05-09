<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/9
 * Time: 17:55
 */

$dataMaps = array(
    'Customer' => array(
        'id' => 'id',
        'name' => 'name',
        'sign' => 'sign',
        'face' => 'face',
        'faceUrl' => 'faceUrl',
        'blogcount' => 'blogCount',
        'fanscount' => 'fansCount',
        'uptime' => 'upTime'
    ),
);

function M($model,$data) {
    global $dataMaps;
    $dataMap = isset($dataMaps[$model]) ? $dataMaps[$model] : null;
    if($dataMap) {
        $dataResult = array();
        foreach ((array)$data as $key => $value) {
            if(array_key_exists($key,$dataMap)) {
                $mapKey = $dataMap[$key];
                $dataResult[$mapKey] = $value;
            }
        }
        return $dataResult;
    }
    return $data;
}