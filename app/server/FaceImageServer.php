<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/11
 * Time: 13:58
 * 头像的控制器
 */
require_once __UTILS . '/Image.php';
class FaceImageServer extends BaseServer {
    private $imageHost;
    public function __construct() {
        $this->imageHost = __WEBSITE_URL;
    }

    /*
     * @title 查看用户头像接口
	 * @action ?server=FaceImage&action=faceView
	 * @params faceId 0 STRING
	 * @method get
     */
    public function faceViewAction() {
        $faceId = isset($_GET['faceId']) ? $_GET['faceId'] : 0;
        if(empty($faceId)) {
            $faceImage = FaceImageUtil::getFaceImage($faceId);
            $this->render('10000', 'Get face ok', array(
                'Image' => $faceImage
            ));
        }
        $this->render('14012', 'Get face failed');
    }

    /*
     * @title 头像列表接口
	 * @action ?server=FaceImage&action=faceList
	 * @method get
     */
    public function faceListAction() {
        // valid face ids
        $faceIdArr = range(0,14);
        // get face images
        $faceList = array();
        foreach ($faceIdArr as $faceId) {
            $faceList[] = FaceImageUtil::getFaceImage($faceId);
        }
        $this->render('10000', 'Get face list ok', array(
            'Image.list' => $faceList
        ));
    }
}