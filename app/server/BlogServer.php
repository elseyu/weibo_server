<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/10
 * Time: 20:57
 */
class BlogServer extends BaseServer {

    /**
     * @title 微博列表接口
     * @action ?server=blog&action=blogList
     * @params typeId 0 0：全部，1：自己，2：关注
     * @params pageId 0 INT
     * @method get
     */
    public function blogListAction() {
        $this->doAuth();

        $typeId = $_GET['typeId'];
        $pageId = $_GET['pageId'];
        $blogList = array();
        $blogDao = ModelFactory::M('BlogDao');
        switch($typeId) {
            case 0:
                $blogList = $blogDao->getBlogsByPage($pageId);
                break;
            case 1:
                $blogList = $blogDao->getBlogsByCustomerId($this->customer['id']);
                break;
            case 2:
                break;    //暂时没有实现
        }

        if($blogList) {
            foreach($blogList as &$row) {
                if(strlen($row['picture']) > 0) {
                    $row['picture'] = __PICTURE_URL . $row['picture'];
                }
            }
            $this->render('10000','Get blog list OK!',array(
                'Blog.list' => $blogList
            ));
        }
        $this->render('10004','Get blog list failed!');
    }

    /**
     * @title 查看微博详细信息接口
     * @action ?server=blog&action=viewBlog
     * @params blogId 0 0：全部，1：自己，2：关注
     * @method post
     */
    public function viewBlogAction() {
        $this->doAuth();

        $blogId = $_POST['blogId'];
        if($blogId) {
            $blogDao = ModelFactory::M('BlogDao');
            $blog = $blogDao->getBlogById($blogId);
            if($blog) {
                $customerDao = ModelFactory::M('CustomerDao');
                $customer = $customerDao->getById($blog['customerid']);
                $this->render('10000','Get blog OK!',array(
                    'Customer' => $customer,
                    'Blog' => $blog
                ));
            } else {
                $this->render('10004','Get blog failed:no such blog:blogId:' . $blogId);
            }
        }
        $this->render('10004','Get blog failed:blogId is empty');
    }

    /*
     * @title 发表微博接口
	 * @action ?server=blog&action=createBlog
	 * @params content '' STRING
	 * @method post
	 *
     */
    public function createBlogAction() {
        //验证登录
        $this->doAuth();
        $content = $_POST['content'];
        if($content) {
            $uploadFileUrl = '';
            $uploadErr = $_FILES['file0']['error']; //获取错误信息
            $uploadFile = $_FILES['file0']['tmp_name']; //获取图片对象
            $uploadFileName = $_FILES['file0']['name']; //获取文件名

            //处理图片的逻辑 这里只能处理一张图片
            if($uploadFileName) {
                //获取文件扩展名信息
                $uploadFileExt = pathinfo($uploadFileName,PATHINFO_EXTENSION);
                //如果没有发生错误
                if($uploadErr == 0) {
                    //拿到保存图片的路径
                    $uploadImageDir = __PICTURE_DIR . '/';
                    //用时间戳和随机函数对文件名进行加密
                    $uploadFileName = md5(time() . rand(100000,999999));
                    //获取文件完整路径
                    $uploadFilePath = $uploadImageDir . $uploadFileName . '.' . $uploadFileExt;
                    //将服务器上的临时图片移动至文件的完整路径
                    if(!move_uploaded_file($uploadFile,$uploadFilePath)) {
                        //移动失败
                        $this->render('10004','Create blog failed:move image failed!');
                    } else {
                        //如果一切顺利，应该拿到的文件名
                        $uploadFileUrl = __PICTURE_URL . $uploadFileName . '.' . $uploadFileExt;
                    }
                } else {
                    $this->render('10004','Create blog failed:upload image failed!');
                }
            }

            //创建微博的逻辑
            $blogDao = ModelFactory::M('BlogDao');
            $blogDao->createBlog($this->customer['id'],'',$content,$uploadFileUrl);
            //增加微博数目
            $customerDao = ModelFactory::M('CustomerDao');
            $customerDao->addBlogCount($this->customer['id']);
            $this->render('10000','Create blog OK!');
        }
        $this->render('10004','Create blog failed:content is empty!');
    }
}