<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/9
 * Time: 20:55
 */
class SessionUtil {
    public function __construct()
    {
        $sid = $_SERVER['HTTP_SID'] ? $_SERVER['HTTP_SID'] : @$_REQUEST['sid'];
        if ($sid) session_id($sid);
    }
}

//echo $_SERVER['HTTP_SID'];