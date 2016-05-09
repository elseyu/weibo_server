<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 20:29
 */
require_once 'AppMySQL.php';
class BaseModel {
    protected $dao = null;
    function __construct() {
        $this->dao = AppMySQL::getInstance(DBConfig::$config);
    }
}

//$model = new BaseModel();
//var_dump($model);