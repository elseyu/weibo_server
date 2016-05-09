<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 22:18
 */
class DebugServer extends BaseServer{

    private $index;
    private $apiAuth;
    private $apiQuit;
    private $apiHome;
    private $apiList;
    private $apiStat;

    private $serverApiList;

    function __construct() {
        $this->index = '?server=debug';
        $this->apiAuth = '?server=debug&action=auth';
        $this->apiQuit = '?server=debug&action=quit';
        $this->apiHome = '?server=debug&action=apiHome';
        $this->apiList = '?server=debug&action=apiList';
        $this->apiStat = '?server=debug&action=apiStat';

        $this->serverApiList = $this->getServerApiList();

        $this->printHeader();
    }

    protected function printHeader() {
        include __APP_PATH_TPL . DIRECTORY_SEPARATOR . 'debug_header.tpl';
    }

    protected function printFooter() {
        include __APP_PATH_TPL . DIRECTORY_SEPARATOR . 'debug_footer.tpl';
    }

    protected function printMenu() {
        echo "<a href='{$this->apiHome}'>Home</a>\n";
        echo "| <a href='{$this->apiList}'>Api Test</a>\n";
        echo "| <a href='{$this->apiStat}'>Api Stat</a>\n";
        echo "| <a href='{$this->apiQuit}'>Logout</a>\n";
        echo "<hr/>\n";
    }

    public function indexAction() {
        $api_doc = __ROOT . DIRECTORY_SEPARATOR . 'doc-api' . DIRECTORY_SEPARATOR . 'index.tpl';
        $lib_doc = __ROOT . DIRECTORY_SEPARATOR . 'doc-lib' . DIRECTORY_SEPARATOR . 'index.tpl';

        echo "&gt; <a href=\"?server=Debug&action=apiHome\">Debug Console</a><br/>\n";
        echo "&gt; <a href=\"javascript:alert('运行脚本后请打开：".addslashes($api_doc)."');\">Api Document</a><br/>\n";
        echo "&gt; <a href=\"javascript:alert('运行脚本后请打开：".addslashes($lib_doc)."');\">Lib Document</a><br/>\n";
//        $this->printFooter();
    }

    public function authAction() {
        if(isset($_POST['user']) && $_POST['pass']) {
            $userName = $_POST['user'];
            $pass = $_POST['pass'];
            if($userName && $pass) {
                if($userName == 'admin' && $pass == 'admin') {
                    $this->admin['name'] = $userName;
                    $_SESSION['admin'] = $this->admin;
//                    var_dump($_SESSION['admin']);
                    $this->forward($this->apiHome);
                } else {
                    echo '用户名密码不正确';
                }
            }
        } else {
            include __APP_PATH_TPL . DIRECTORY_SEPARATOR . 'debug_login.tpl';
        }
    }

    public function quitAction() {
        $_SESSION['admin'] = null;
        $this->forward($this->index);
    }

    public function apiHomeAction() {
        $this->checkAdmin();
        $this->printMenu();

        echo "<table class='tbcom' cellpadding=0 cellspacing=0>\n";
        echo "<tr><td style='width:80px;'>&gt; Api Test</td><td style='width:10px;'>:</td><td>实时接口测试</td></tr>";
        echo "<tr><td style='width:80px;'>&gt; Api Stat</td><td style='width:10px;'>:</td><td>接口访问统计</td></tr>";
        echo "</table>\n";
        echo "<hr/>\n";

        echo "<b>Welcome <font color=red>{$this->admin['name']}</font></b>";
    }

    public function apiStatAction() {
        $this->checkAdmin();
        $this->printMenu();
        $html = "<table class='tbfix' cellpadding=1 cellspacing=1>\n";
        foreach ((array) $this->serverApiList as $serviceName => $actionList) {
            $html .= "<tr><td class='title' colspan=4>{$serviceName}</td></tr>\n";
            foreach ((array) $actionList as $actionName => $actionConfig) {
                $actionKey = "$serviceName::$actionName";
                $visit = 0; // count visit count
                $runtime = 0; // count average visit runtime
                $html .= "<tr><td>{$actionName}</td><td>接口地址：{$actionConfig['action']}</td><td>访问次数：{$visit}</td><td>平均响应时间：{$runtime}</td></tr>\n";
            }
        }
        $html .= "</table>\n";
        echo $html;
    }

    public function apiListAction() {
        $this->checkAdmin();
        $this->printMenu();
        $html = "<table class='tbfix' cellpadding=1 cellspacing=1>\n";
        foreach ((array) $this->serverApiList as $serviceName => $actionList) {
            $html .= "<tr><td class='title' colspan=4>{$serviceName}</td></tr>\n";
            foreach ((array) $actionList as $actionName => $actionConfig) {
                $html .= "<tr><td>{$actionName}</td><td>{$actionConfig['title']}</td><td>{$actionConfig['action']}</td><td><a href='?server=debug&action=apiTest&serviceName={$serviceName}&actionName={$actionName}'>测试</a></td></tr>\n";
            }
        }
        $html .= "</table>\n";
        echo $html;
    }

    public function apiTestAction ()
    {
        $this->checkAdmin();
        $this->printMenu();

        echo "<script type='text/javascript' src='/js/debug/apiTest.js'></script>\n";
        echo "<script type='text/javascript'>\n";
        echo "$(document).ready(function(){";
        echo "var header={};";
        echo "$('.doTest').click(function(){apiTest(header)});";
        echo "});\n";
        echo "</script>\n";

        $serviceName = $_GET['serviceName'];
        $actionName = $_GET['actionName'];
        $configList = $this->serverApiList[$serviceName][$actionName];
        if (!$configList) {
            echo "Error : can not found '$serviceName::$actionName'.\n";
            exit;
        }

        // append sid
//        $configList['action'] = $this->url->format($configList['action']);

        $action = $configList['action'];
        $method = $configList['method'];
        $html = "<input type='hidden' id='action' value='{$action}'/>\n";
        $html .= "<input type='hidden' id='method' value='{$method}'/>\n";
        $html .= "<table class='tbcom' cellpadding=1 cellspacing=1>\n";
        $html .= "<tr><td class='title' colspan=2>{$serviceName} > {$actionName}</td></tr>\n";
        foreach ((array) $configList as $configKey => $configVal) {
            // action params
            if (is_array($configVal)) {
                $html .= "<tr><td>Test Data</td><td><table>\n";
                foreach ((array) $configVal as $paramName => $paramData) {
                    $paramDval = $paramData['dval']; // default value
                    $paramDesc = $paramData['desc']; // description
                    $html .= "  <tr><td>KEY : <input type='text' name='paramKey' value='{$paramName}'/> VALUE : <input type='text' name='paramVal' style='width:300px' value='$paramDval'/> ({$paramDesc}) </td></tr>\n";
                }
                $html .= "</table></td></tr>\n";
                // action attr
            } else {
                $html .= "<tr><td class='left'>{$configKey}</td><td>{$configVal}</td></tr>\n";
            }
        }
        $html .= "<tr><td class='left'>Test Submit</td><td><input type='button' class='doTest' value='提交测试'/></td></tr>\n";
        $html .= "<tr><td class='left'>Test Result</td><td><textarea id='result'></textarea></td></tr>\n";
        $html .= "</table>\n";
        echo $html;
    }

    protected function getServerApiList() {
        require_once __LIB . DIRECTORY_SEPARATOR . '/Document.php';
        $serverApiList = array();
        foreach(glob(__APP_PATH_SERVER . DIRECTORY_SEPARATOR . '*.php') as $classFile) {
            $className = basename($classFile,'.php');
            if($classFile && $className) {
                $class = new ReflectionClass($className);
                $methodList = $class->getMethods();
                $doc = new Hush_Document($classFile);
                foreach($methodList as $method) {
                    $config = $doc->getAnnotation($className, $method->name);
                    if($config && preg_match('/Action$/',$method->name)) {
                        $serverApiList[$className][$method->name] = $config;
                    }
                }
            }
        }
        return $serverApiList;
    }

    private function checkAdmin() {
        if(!isset($_SESSION['admin'])) {
            echo '请登录';
//            var_dump($_SESSION['admin']);
            $this->forward($this->apiAuth);
        } else {
            $this->admin = $_SESSION['admin'];
        }
    }

    function __destruct() {
        $this->printFooter();
    }

}
