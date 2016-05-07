<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/7
 * Time: 20:59
 * 单例模型工厂
 */
class ModelFactory {
    Static $allModel = array();
    public Static function M($modelName) {
        if(!isset(ModelFactory::$allModel[$modelName])
            || !(ModelFactory::$allModel[$modelName] instanceof $modelName)) {
            self::$allModel[$modelName] = new $modelName();
        }
        return self::$allModel[$modelName];
    }
}