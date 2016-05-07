<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 21:08
 */
require_once 'BaseModel.php';
class BaseServer {

    /**
     * @param $code
     * @param $message
     * @param $result
     * 打印方法
     */
    function render($code, $message, $result) {
//        echo 'Hello!!';
    }

    /**
     * @param $url
     * URL跳转方法
     */
    function forward($url) {
        header("Location: $url");
    }
}

$test = new BaseServer();
$test->render('','','');