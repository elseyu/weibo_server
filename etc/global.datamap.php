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
    'Blog' => array(
        'id' => 'id',
        'face' => 'face',
        'author' => 'author',
        'content' => 'content',
        'picture' => 'picture',
        'comment' => 'comment',
        'uptime' => 'uptime',
    ),
    'Comment' => array(
        'id' => 'id',
        'content' => 'content',
        'uptime' => 'uptime',
    ),
    'Image' => array(
        'id' => 'id',
        'url' => 'url',
        'type' => 'type',
    ),
    'Notice' => array(
        'id' => 'id',
        'message' => 'message'
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