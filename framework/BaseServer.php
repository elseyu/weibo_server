<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 21:08
 */
require_once 'BaseModel.php';
class BaseServer {

    protected $customer;

    public function __construct() {
        //session_start();
    }

    /**
     * @param $code
     * @param $message
     * @param $result
     * 打印方法
     */
    function render($code, $message, $result = '') {
//        echo 'Hello!!';
        if(is_array($result)) {
            foreach($result as $name => $data) {
                if(strpos($name,'.list')) {
                    $model = trim(str_replace('.list','',$name));
                    foreach((array)$data as $key => $value) {
                        $result[$name][$key] = M($model,$value);
                    }
                } else {
                    $model = trim($name);
                    $result[$name] = M($model,$data);
                }
            }
        }

        echo json_encode(array(
            'code' => $code,
            'message' => $message,
            'result' => $result
        ));
        exit;
    }

    /**
     * @param $url
     * URL跳转方法
     */
    function forward($url) {
        header("Location: $url");
    }

    function doAuth() {
        if(!isset($_SESSION['customer'])) {
            $this->render('10001','Please login first','');
        } else {
            $this->customer = $_SESSION['customer'];
        }
    }
}
