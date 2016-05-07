<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 17:44
 */
class AppMySQL {

    private $mysqli; //组合用的mysqli对象
    private $host; //主机地址
    private $port; //端口号
    private $user; //用户名
    private $pass; //密码
    private $charset; //字符编码
    private $dbName; //数据库名字

    /**
     * AppMySQL constructor. 私有化构造方法，目的是构造单例模式
     * @param $config  .配置的数组，数组如果没有相应的参数会选择默认值
     * 构造函数 new出来的时候直接构建
     */
    private function __construct($config) {
        $this->host = !empty($config['host']) ? $config['host'] : 'localhost';
        $this->port = !empty($config['port']) ? $config['port'] : '3306';
        $this->user = !empty($config['user']) ? $config['user'] : 'root';
        $this->pass = !empty($config['pass']) ? $config['pass'] : '';
        $this->charset = !empty($config['charset']) ? $config['charset'] : 'utf8';
        $this->dbName = !empty($config['dbName']) ? $config['dbName'] : 'weibo_server';

        $this->mysqli = new mysqli($this->host,$this->user,$this->pass,$this->dbName,$this->port);
        if ($this->mysqli->connect_errno) {
            //对任何sql语句，执行失败，都需要处理这种失败情况：
            echo "<p>sql语句执行失败，请参考如下信息：";
            echo "<br />错误代号：" . $this->mysqli->connect_errno;	//获取错误代号
            echo "<br />错误信息：" . $this->mysqli->connect_error;	//获取错误提示内部
            die();
        }

        $this->mysqli->set_charset($this->charset);
    }

    //该类的单例对象
    private static $instance = null;

    /**
     * @param $config
     * @return AppMySQL|null
     * 获取单例的方法
     */
    public static function getInstance($config) {
        if(!(self::$instance instanceof self)) {
            self::$instance = new AppMySQL($config);
        }
        return self::$instance;
    }

    //覆盖该类的clone方法 进一步实现单例化
    function __clone() {}

    /**
     * 关闭数据库
     */
    function closeDB() {
        $this->mysqli->close();
    }

    /**
     * 这个方法是执行一条增删改的语句 返回应该是bool类型
     * @param $sql .要执行的语句
     * @return bool|mysqli_result
     */
    function exec($sql) {
        $result = $this->query($sql);
        return $result;
    }

    /**
     * 获取一行数据
     * @param $sql
     * @return mixed
     */
    function getOneRow($sql) {
        $result = $this->query($sql);
        $rec = $result->fetch_array(MYSQLI_BOTH);
        $result->close();
        return $rec;
    }

    /**
     * 获取多行数据
     * @param $sql
     * @return mixed
     */
    function getRows($sql) {
        $result = $this->query($sql);
        $rec = $result->fetch_all(MYSQLI_BOTH);
        $result->close();
        return $rec;
    }

    /**
     * 获取单个数据
     * @param $sql
     * @return mixed
     */
    function getOneData($sql) {
        $result = $this->query($sql);
        $rec = $result->fetch_row();
        $data = $rec[0];
        $result->close();
        return $data;
    }

    /**
     * 查询方法
     * @param $sql
     * @return bool|mysqli_result
     */
    function query($sql) {
        $result = $this->mysqli->query($sql);
        if( $result === false){
            //对任何sql语句，执行失败，都需要处理这种失败情况：
            echo "<p>sql语句执行失败，请参考如下信息：";
            echo "<br />错误代号：" . $this->mysqli->connect_errno;	//获取错误代号
            echo "<br />错误信息：" . $this->mysqli->connect_error;	//获取错误提示内部
            echo "<br />错误语句：" . $sql;
            die();
        }
        return $result;	//返回的是“执行的结果”
    }
}