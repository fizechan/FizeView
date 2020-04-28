<?php

namespace fize\view;

/**
 * 视图工厂
 */
class ViewFactory
{

    /**
     * 创建实例
     * @param string $handler 处理器
     * @param array  $config  参数配置
     * @return ViewHandler
     */
    public static function create($handler, $config = [])
    {
        $class = '\\' . __NAMESPACE__ . '\\handler\\' . $handler;
        return new $class($config);
    }
}
