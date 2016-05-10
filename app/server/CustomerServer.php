<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/8
 * Time: 22:20
 */
class CustomerServer extends BaseServer {

    private $dao;
    public function __construct() {
        $this->dao = new CustomerDao();
        //$this->dao = ModelFactory::M('CustomerDao');
    }

    /*
    * @title 查看用户列表接口
    * @action ?server=customer&action=customerList
    * @method get
    */
    public function customerListAction() {
        //验证登录
        $this->doAuth();

        $customerList = $this->dao->getListByPage();
        $this->render('10000','Get customer list OK!',
            array('Customer.list' => $customerList));
    }

    /*
    * @title 查看用户接口
    * @action ?server=customer&action=customerView
    * @params customerId '' INT
    * @method post
    */
    public function customerViewAction() {
        $this->doAuth();

        $customerId = isset($_POST['customerId']) ? $_POST['customerId'] : null;
        if(!$customerId) {
            $this->render('10005','请求参数不存在');
        }
        $customer = $this->dao->getById($customerId);
        if($customer) {
            $this->render('10000','View customer OK!',array(
               'Customer' => $customer
            ));
        } else {
            $this->render('10004','View customer failed!');
        }
    }

    /*
    * @title 更新用户接口
    * @action ?server=customer&action=customerEdit
    * @params key '' STRING
    * @params value '' STRING
    * @method post
    */
    public function customerEditAction() {
        $this->doAuth();

        $key = isset($_POST['key']) ? $_POST['key'] : null;
        $value = isset($_POST['value']) ? $_POST['value'] : null;

        if($key) {
            $result = $this->dao->updateInfo($this->customer['id'],$key,$value);
            if($result) {
                $this->render('10000', 'Update customer ok');
            } else {
                $this->render('14003', 'Update customer failed');
            }
        }
        $this->render('14003', 'Update customer failed');
    }
    /*
    * @title 新建用户接口
    * @action ?server=customer&action=customerCreate
    * @params name '' STRING
    * @params pass '' STRING
    * @params sign '' STRING
    * @params face '0' STRING
    * @method post
    */
    public function customerCreateAction() {
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $pass = isset($_POST['pass']) ? $_POST['pass'] : null;
        $sign = isset($_POST['sign']) ? $_POST['sign'] : null;
        $face = isset($_POST['face']) ? $_POST['face'] : null;

        if($name && $pass && $sign && $face) {
            $result = $this->dao->createCustomer($name,$pass,$sign,$face);
            if($result) {
                $this->render('10000', 'Create customer ok');
            } else {
                $this->render('10004', 'Create customer failed');
            }
        }
        $this->render('10004', '参数不完整');
    }

    /**
     * 新建用户接口,请求post
     * 测试接口
     */
//    public function testCustomerCreateAction() {
//        $name = isset($_POST['name']) ? $_POST['name'] : null;
//        $pass = isset($_POST['pass']) ? $_POST['pass'] : null;
//        $sign = isset($_POST['sign']) ? $_POST['sign'] : null;
//        $face = isset($_POST['face']) ? $_POST['face'] : null;
//
//        if($name && $pass && $sign && $face) {
//            $result = $this->dao->createCustomer($name,$pass,$sign,$face);
//            if($result) {
//                $this->render('10000', 'Create customer ok');
//            } else {
//                $this->render('10004', 'Create customer failed');
//            }
//        }
//
//        include __APP_PATH_TPL . DIRECTORY_SEPARATOR . 'debug_header.tpl';
//        include __APP_PATH_TPL . DIRECTORY_SEPARATOR . 'test_createcustomer.tpl';
//        include __APP_PATH_TPL . DIRECTORY_SEPARATOR . 'debug_footer.tpl';
//    }

    public function addFansAction() {
        $this->doAuth();

        $fansId = isset($_POST['fansId']) ? $_POST['fansId'] : null;
        if($fansId) {
            $fansDao = new CustomerFansDao();
            //$fansDao = ModelFactory::M('CustomerFansDao');
            //如若粉丝关系不存在
            if(!$fansDao->exist($this->customer['id'],$fansId)) {
                $fansDao->createFans($this->customer['id'],$fansId);
            }

            $this->dao->addFansCount($this->customer['id']);
        }

    }

    public function testAction() {
        $customer = $this->dao->getById(1);
//        var_dump($customer);
    }
}