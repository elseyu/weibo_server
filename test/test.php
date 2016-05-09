<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/8
 * Time: 14:57
 */
$sql = 'select * from ' . 'customer' .
    ' where ' . 'customer' . '.name = ' . 'name' .
    ' and ' . 'customer' . '.pass = ' . 'pass';
echo $sql;