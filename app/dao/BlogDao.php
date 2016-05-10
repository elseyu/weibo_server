<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/10
 * Time: 16:11
 */
require_once '../../etc/app.config.php';
require_once __FRAMEWORK . '/BaseModel.php';
class BlogDao extends BaseModel {
    private $tableName = 'blog'; //表名
    private $tablePrim = 'id'; //表的主键 这里为id

    public function createBlog($customerid,$title,$content,$picture) {
        $sql = "insert into $this->tableName (customerid,title,content,picture)
                    values ($customerid,'$title','$content','$picture')";
        return $this->dao->exec($sql);
    }

    /**
     * @param $id
     * @param int $addCount
     * 增加评论数，默认增加1
     */
    public function addCommentCount($id,$addCount = 1) {
        $blog = $this->getBlogById($id);
        $blogCount = (int)$blog['commentcount'] + $addCount;
        if($blog['commentcount']) {
            $sql = "update $this->tableName set commentcount = $blogCount where id = $id";
            $this->dao->exec($sql);
        }
    }

    /**
     * @param $id
     * @return mixed
     * 根据id获取评论
     */
    public function getBlogById($id) {
        $sql = "select * from $this->tableName where $this->tablePrim = $id";
        $blog = $this->dao->getOneRow($sql);
        return $blog;
    }

    /**
     * @param $customerId
     * @param int $pageId
     * @return array
     * 获取用户所有微博 （页数id指定）
     */
    public function getBlogsByCustomerId($customerId,$pageId = 0) {
        $pageId = ((int)$pageId) * 10;
        $sql = "select * from $this->tableName where customerid = $customerId
                  order by uptime desc limit $pageId , 10";
        $blogs = $this->dao->getRows($sql);
        $blogList = array();
        if($blogs) {
            $customerDao = new CustomerDao();
            foreach($blogs as $blog) {
                $customer = $customerDao->getById($blog['customerid']);
                $blog = array(
                    'id' => $blog['id'],
                    'content' => $customer['name'] . ':' . $blog['content'],
                    'comment' => '评论(' . $blog['commentcount'] . ')',
                    'picture' => $blog['picture'],
                    'uptime' => $blog['uptime']
                );
                array_push($blogList,$blog);
            }
        }

        return $blogList;
    }

    /**
     * @param int $pageId
     * @return array
     * 获取所有微博
     */
    public function getBlogsByPage($pageId = 0) {
        $pageId = ((int)$pageId) * 10;
        $sql = "select * from $this->tableName
                  order by uptime desc limit $pageId , 10";
        $blogs = $this->dao->getRows($sql);
        $blogList = array();
        if($blogs) {
            $customerDao = new CustomerDao();
            foreach($blogs as $blog) {
                $customer = $customerDao->getById($blog['customerid']);
                $blog = array(
                    'id' => $blog['id'],
                    'content' => $customer['name'] . ':' . $blog['content'],
                    'comment' => '评论(' . $blog['commentcount'] . ')',
                    'picture' => $blog['picture'],
                    'uptime' => $blog['uptime']
                );
                array_push($blogList,$blog);
            }
        }

        return $blogList;
    }
}