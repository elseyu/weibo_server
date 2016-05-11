<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/10
 * Time: 18:30
 */
require_once '../../etc/app.config.php';
require_once __FRAMEWORK . '/BaseModel.php';
class CommentDao extends BaseModel {
    private $tableName = 'comment'; //表名
    private $tablePrim = 'id'; //表的主键 这里为id

    public function createComment($blogid,$customerid,$content) {
        $sql = "insert into $this->tableName (blogid,customerid,content) values ($blogid,$customerid,'$content')";
        return $this->dao->exec($sql);
    }

    /*
     * 通过微博的id获取评论信息
     */
    public function getCommentsByBlogId($blogId,$pageId = 0) {
        $pageId = ((int)$pageId) * 10;
        $sql = "select * from $this->tableName
                  where blogid = $blogId order by uptime limit $pageId,10";
        $result = $this->dao->getRows($sql);
        $commentList = array();
        if($result) {
            $customerDao = new CustomerDao();
            foreach($result as $row) {
                $customer = $customerDao->getById($row['customerid']);
                $comment = array(
                    'id' => $row['id'],
                    'content' => $customer['name'] . ':' . $row['content'],
                    'uptime' => $row['uptime']
                );
                array_push($commentList,$comment);
            }
        }

        return $result;

    }

    /*
     * 通过用户的id获取评论信息
     */
    public function getByCustomerId($customerId, $pageId = 0) {
        $pageId = ((int)$pageId) * 10;
        $sql = "select * from $this->tableName
                  where customerid = $customerId order by uptime limit $pageId,10";
        return $this->dao->getRows($sql);
    }
}