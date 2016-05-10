<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 21:45
 */
class IndexServer extends BaseServer {
    private $dao;
    public function __construct() {
        $this->dao = new CustomerDao();
    }

    /*
    * @title 主页接口
    * @action ?server=index&action=index
    * @method get
    */
    function indexAction() {
//        echo 'Hello Index!!';
        $this->doAuth();
        //$this->customer 已经在doAuth()里面定义过，其实就是$_SESSION['customer']
        $customer = $this->dao->getById($this->customer['id']);
        $this->render('10000','Hello Index!',array(
            'Customer' => $customer
        ));
    }

    /*
    * @title 登录接口
    * @action ?server=index&action=login
    * @params name test STRING
    * @params pass test STRING
    * @method post
    */
    public function loginAction() {
//        if(!isset($_POST['name'])) {
//            $this->render('14001','Login Failed!请输入用户名','');
//        }
//        if(!isset($_POST['pass'])) {
//            $this->render('14001','Login Failed!请输入密码','');
//        }
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $pass = isset($_POST['pass']) ? $_POST['pass'] : null;

        if($name && $pass) {
            $customer = $this->dao->doAuth($name,$pass);
            if($customer) {
                $_SESSION['customer'] = $customer;
                $this->render('10000','Login OK!',array('Customer' => $customer));
            };
        }

        //render()方法如若执行，就会结束程序，所以下面是失败的输出
        $this->render('14001','Login Failed!');
    }

    /*
    * @title 登出接口
    * @action ?server=index&action=logout
    * @method get
    */
    public function logoutAction() {
        $_SESSION['customer'] = null;
        $this->render('10000','Logout OK!');
    }

    /*
    * @title 测试登录接口
    * @action ?server=index&action=testLogin
    * @params name test STRING
    * @params pass test STRING
    * @method post
    */
    public function testLoginAction() {
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $pass = isset($_POST['pass']) ? $_POST['pass'] : null;

        if($name && $pass) {
            $customer = $this->dao->doAuth($name,$pass);
            if($customer) {
                $_SESSION['customer'] = $customer;
                $this->render('10000','Login OK!',array('Customer' => $customer));
            };
        }

        include __APP_PATH_TPL . DIRECTORY_SEPARATOR . 'debug_header.tpl';
        include __APP_PATH_TPL . DIRECTORY_SEPARATOR . 'test_login.tpl';
        include __APP_PATH_TPL . DIRECTORY_SEPARATOR . 'debug_footer.tpl';
    }

    function testAction() {
        echo 'My Test API';
    }
}