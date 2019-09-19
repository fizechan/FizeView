<?php


namespace fize\view;

/**
 * 视图类
 * @package fize\view
 */
class View
{

    /**
     * @var ViewHandler
     */
    private static $handler;

    /**
     * 取得单例
     * @param string $driver 驱动
     * @param array $config 参数配置
     * @return ViewHandler
     */
    public static function getInstance($driver, array $config = [])
    {
        if (empty(self::$handler)) {
            $class = '\\' . __NAMESPACE__ . '\\handler\\' . $driver;
            self::$handler = new $class($config);
        }
        return self::$handler;
    }

}