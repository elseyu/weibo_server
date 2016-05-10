<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/10
 * Time: 13:12
 */
class CustomerFansDao extends BaseModel{
    private $tableName = 'customer_fans'; //表名
    private $tablePrim = ''; //表的主键 这里为空，因为一组数据由customerid 、fansid决定

    /*
     * 判断是否已经为粉丝关系
     */
    public function exist($customerId, $fansId) {
        $sql = "select * from $this->tableName
                  where customerid = $customerId and fansid = $fansId";
        return $this->dao->getOneRow($sql);
    }

    /*
     * 删除粉丝关系
     */
    public function delete($customerId, $fansId) {
        $sql = "delete from $this->tableName
                  where customerid = $customerId and fansid = $fansId";
        return $this->dao->exec($sql);
    }

    /*
     * 统计粉丝数
     */
    public function getFansCount($customerId) {
        $sql = "select count(*) from $this->tableName where customerid = $customerId";
        return $this->dao->getOneData($sql);
    }

    /*
     * 获取所有粉丝，粉丝按添加时间排序
     */
    public function getFans($customerId) {
        $sql = "select fansid from $this->tableName where customerid = $customerId ORDER BY uptime";
        return $this->dao->getRows($sql);
    }

    /*
     *增加粉丝
     */
    public function createFans($customerId, $fansId) {
        $sql = "INSERT INTO $this->tableName (customerid, fansid) VALUES ($customerId, $fansId);";
        return $this->dao->exec($sql);

    }
}