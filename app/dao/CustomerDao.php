<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/8
 * Time: 22:29
 */
require_once '../../etc/app.config.php';
require_once __FRAMEWORK . '/BaseModel.php';

class CustomerDao extends BaseModel{
    private $tableName = 'customer';
    private $tablePrim = 'id';

    public function doAuth($name, $pass) {
        $sql = "select * from  $this->tableName
            where  $this->tableName.name = '$name'
            and $this->tableName.pass = '$pass'";

        $user = $this->dao->getOneRow($sql);
//        var_dump($user);
        if($user) {
            $user['faceUrl'] = __WEBSITE_URL . 'faces/default' . $user['face'];
            return $user;
        } else {
            return false;
        }
    }

    public function getById($id) {
        $sql = "select * from $this->tableName
            where  $this->tableName.$this->tablePrim = $id ";
        $customer = $this->dao->getOneRow($sql);

        $customer['faceUrl'] = __WEBSITE_URL . 'faces/default' . $customer['face'];
//        var_dump($customer);
        return $customer;
    }

    public function addBlogCount($id,$count = 1) {
        $sql = "UPDATE $this->tableName SET blogcount = blogcount+$count WHERE id = $id";
        $result = $this->dao->exec($sql);
        return $result;
    }

    public function addFansCount($id,$count = 1) {
        $sql = "UPDATE $this->tableName SET fanscount = fanscount+$count WHERE id = $id";
        $result = $this->dao->exec($sql);
        return $result;
    }

    public function getListByPage($pageId = 0) {
        $sql = "select * from $this->tableName
            ORDER  BY $this->tableName.uptime ";
        $customer = $this->dao->getRows($sql);
//        var_dump($customer);
        return $customer;
    }

    public function updateInfo($id,$key,$value) {
        $sql = "UPDATE $this->tableName SET $key = '$value' WHERE id = $id";
        $result = $this->dao->exec($sql);
        return $result;
    }

    public function createCustomer($name, $pass, $sign, $face) {
        $sql = "INSERT INTO customer(name, pass, sign, face)
                  VALUES ('$name','$pass','$sign','$face')";
        $result = $this->dao->exec($sql);
        return $result;
    }
}

//$test = new CustomerDao();
//$test->addFansCount(1);
//$test->doAuth('test','test');
//$test->getListByPage();
//$test->updateInfo(1,'sign','我更新啦！！！');