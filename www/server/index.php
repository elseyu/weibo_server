<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 16:38
 */

require_once '../../etc/app.config.php';

$serverParam = !empty($_GET[__SERVER]) ? $_GET[__SERVER] : 'Debug';

function __autoload($className) {

}

$serverName = $serverParam . 'Server';
$server = new $serverName();

$action = !empty($_GET[__ACTION]) ? $_GET[__ACTION] : 'index';
$server -> $action();

