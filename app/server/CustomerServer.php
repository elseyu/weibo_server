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

    public function customerListAction() {
        //验证登录
//        $this->doAuth();

        $customerList = $this->dao->getListByPage();
        $this->render('10000','Get customer list OK!',
            array('Custom.list' => $customerList));
    }



    public function testAction() {
        $customer = $this->dao->getById(1);
//        var_dump($customer);
    }
}