<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 16:34
 */

require_once 'global.defines.php';
require_once 'database.config.php';
require_once 'global.datamap.php';
//require_once 'global.session.php';

define('__APP_NAME', 'Demos');
define('__APP_VERSION', '1.0');

/**
 * 路径定义
 */
define('__APP_PATH_SERVER', realpath(__APP . '/server'));
define('__APP_PATH_WEBSITE', realpath(__APP . '/website'));
define('__APP_PATH_DAO', realpath(__APP . '/dao'));
define('__APP_PATH_TPL', realpath(__APP . '/tpl'));

/**
 * URL参数定义
 */
define('__SERVER', 'server');
define('__ACTION', 'action');

define('__SERVER_URL','http://api.demos.app.com:8001/');
define('__WEBSITE_URL','http://demos.app.com:8002/');



