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

    function indexAction() {
        echo 'Hello Index!!';
    }

    public function loginAction() {
        if(!isset($_POST['name'])) {
            $this->render('14001','Login Failed!请输入用户名','');
        }
        if(!isset($_POST['pass'])) {
            $this->render('14001','Login Failed!请输入密码','');
        }
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $pass = isset($_POST['pass']) ? $_POST['pass'] : null;

        if($name && $pass) {
            $customer = $this->dao->doAuth($name,$pass);
            if($customer) {
                $_SESSION['customer'] = $customer;
                $this->render('10000','Login OK!',array('customer' => $customer));
            };
        }

        //render()方法如若执行，就会结束程序，所以下面是失败的输出
        $this->render('14001','Login Failed!','');
    }

    public function testLoginAction() {
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $pass = isset($_POST['pass']) ? $_POST['pass'] : null;

        if($name && $pass) {
            $customer = $this->dao->doAuth($name,$pass);
            if($customer) {
                $_SESSION['customer'] = $customer;
                $this->render('10000','Login OK!',array('customer' => $customer));
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