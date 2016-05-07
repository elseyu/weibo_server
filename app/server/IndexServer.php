<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 21:45
 */
class IndexServer extends BaseServer {
    function indexAction() {
        echo 'Hello Index!!';
    }

    function testAction() {
        echo 'My Test API';
    }
}