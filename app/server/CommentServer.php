<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/10
 * Time: 23:21
 */
class CommentServer extends BaseServer {

    /*
     ** @title 评论列表接口
	 * @action ?server=comment&action=commentList
	 * @params blogId 1 INT
	 * @params pageId 0 INT
	 * @method get
     */
    public function commentListAction() {
        $this->doAuth(); //验证登录

        $blogId = $_GET['blogId'];
        $pageId = $_GET['pageId'];

        if($blogId) {
            $commentDao = ModelFactory::M('CommentDao');
            $commentList = $commentDao->getCommentsByBlogId($blogId,$pageId);
            if($commentList) {
                $this->render('10000','Get comment list OK!',array(
                   'Comment.list' => $commentList
                ));
            } else {
                $this->render('10004','Get comment list failed:no comment by this blog id');
            }
        }
        $this->render('10004','Get comment list failed:blogId is empty');
    }

    /*
     ** @title 发表评论接口
	 * @action ?server=comment&action=createComment
	 * @params blogId 1 INT
     * @params content '' STRING
	 * @method post
     */
    public function createCommentAction() {
        $this->doAuth();

        $blogId = $_POST['blogId'];
        $content = $_POST['content'];

        if($blogId && $content) {
            $blogDao = ModelFactory::M('BlogDao');
            //验证微博是否存在，不存在直接打印错误
            if(!$blogDao->exist($blogId)) {
                $this->render('10004','Blog is not exist!');
            }
            //存在，则新建评论，同时该微博下的评论数要加1
            $commentDao = ModelFactory::M('CommentDao');
            $commentDao->createComment($blogId,$this->customer['id'],$content);
            $blogDao->addCommentCount($blogId);
            $this->render('10000','Create comment OK');
        }
        //参数不完整时直接打印错误
        $this->render('10004','Create comment failed:params empty!');
    }



}