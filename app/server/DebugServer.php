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

    function __construct() {
        $this->index = '?server=debug';
        $this->apiAuth = '?server=debug&action=auth';
        $this->apiQuit = '?server=debug&action=quit';
        $this->apiHome = '?server=debug&action=apiHome';
        $this->apiList = '?server=debug&action=apiList';
        $this->apiStat = '?server=debug&action=apiStat';

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
