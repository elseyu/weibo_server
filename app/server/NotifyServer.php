<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/11
 * Time: 13:39
 */
class NotifyServer extends BaseServer {

    /*
     * @title 获取通知接口
	 * @action ?server=notify&action=getNotice
	 * @method get
     */
    public function getNoticeAction() {
        $this->doAuth();

        $noticeDao = ModelFactory::M('NoticeDao');
        $notice = $noticeDao->getByCustomerId($this->customer['id']);
        if($notice) {
            $noticeDao->setRead($this->customer['id']);
            $this->render('10000','Get notice OK!',array(
                'Notice' => $notice,
            ));
        }

        $this->render('10004','No notify');
    }
}