<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/10
 * Time: 15:10
 */
//require_once '../../etc/app.config.php';
//require_once __FRAMEWORK . '/BaseModel.php';
class NoticeDao extends BaseModel {
    private $tableName = 'notice'; //表名
    private $tablePrim = 'id'; //表的主键 这里为id

    /**
     * 将消息设置为已读,status = 1 为已读，status = 0 为未读
     * @param $customerId
     */
    public function setRead($customerId) {
        $sql = "select * from $this->tableName where customerid = '$customerId' and status = 0";
        $row = $this->dao->getOneRow($sql);

        if($row) {
            $id = $row['id'];
            $sql = "update $this->tableName set status = 1 where id = $id ";
            $this->dao->exec($sql);
        }
    }

    public function addFansCount($customerId, $addCount = 1) {
        $sql = "select * from $this->tableName where customerid = '$customerId' and status = 0";

        $row = $this->dao->getOneRow($sql);
        if($row) {
            $id = $row['id'];
            $fansCount = (int)$row['fanscount'] + $addCount;
            $sql = "update $this->tableName set fanscount = $fansCount where id = $id";
            $this->dao->exec($sql);
        } else {
            $this->createNotice($customerId,1);
        }
    }

    /**
     * @param $customerId
     * @return mixed|null
     * 通过$customerId获取通知
     */
    public function getByCustomerId($customerId) {
        $sql = "select * from $this->tableName where customerid = $customerId and status = 0";
        $row = $this->dao->getOneRow($sql);
        $message = trim($row['massage']);
        if(strlen($message) > 0) {
            var_dump($row);
            return $row;
        }

        $fans = (int)$row['fanscount'];
        if($fans > 0) {
            $row['message'] = L('cn','notice',$row['fanscount']);
            var_dump($row);
            return $row;
        }

        return null;
    }

    /*
     *新增通知
     */
    public function createNotice($customerId, $fansCount,$message='') {
        $sql = "insert into $this->tableName (customerid, fanscount, message)
                  values ($customerId, $fansCount,'$message')";
        $this->dao->exec($sql);
    }

}

$test = new NoticeDao();
$test->getByCustomerId(2);