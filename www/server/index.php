<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 16:38
 */

require_once '../../etc/app.config.php';

$serverParam = !empty($_GET[__SERVER]) ? $_GET[__SERVER] : 'Index';

/**
 * @param $className
 * 实现自动加载
 */
function __autoload($className) {
    $baseClasses = array('AppMySQL', 'BaseModel','BaseServer');
    if(in_array($className,$baseClasses)) {
        require_once __FRAMEWORK. DIRECTORY_SEPARATOR . $className. '.php';
    } else if(substr($className,-6) == 'Server') {
        require_once __APP_PATH_SERVER . DIRECTORY_SEPARATOR . $className . '.php';
    }
}

$serverName = $serverParam . 'Server';
$server = new $serverName();

$action = !empty($_GET[__ACTION]) ? $_GET[__ACTION] : 'index';
$action .= 'Action';
$server -> $action();

