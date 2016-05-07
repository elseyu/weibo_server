<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 16:16
 * Use for: 全局变量的定义文件，主要包含了各种路径，并且为全局设置了include_path
 */

/**
 * 设置全局的时区属性
 */
date_default_timezone_set('PRC');

/**
 * 定义配置文件所在的路径
 */
define('__ETC',dirname(__FILE__));
//var_dump(__ETC);

/**
 * 定义根路径
 */
define('__ROOT',realpath(__ETC . '/../'));
//var_dump(__ROOT);

define('__APP',realpath(__ROOT . '/app'));
//var_dump(__APP);

define('__WWW',realpath(__ROOT . '/www'));
//var_dump(__WWW);

define('__FRAMEWORK', realpath(__ROOT . '/framework'));
var_dump(__FRAMEWORK);

//var_dump(get_include_path());
set_include_path(get_include_path() .  PATH_SEPARATOR . __APP .  PATH_SEPARATOR . __WWW);
//var_dump(get_include_path());




















