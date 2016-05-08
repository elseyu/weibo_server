<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/8
 * Time: 14:57
 */
if(isset($_POST['user']) && $_POST['pass']) {
    $userName = $_POST['user'];
    $pass = $_POST['pass'];
    echo $userName . '___________' . $pass;
}