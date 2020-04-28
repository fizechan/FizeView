<?php

namespace fize\view\handler;

use Foil\Engine;
use Foil\Foil as FoilEngine;
use fize\view\ViewHandler;

/**
 * Foil
 *
 * composer require foil/foil
 */
class Foil implements ViewHandler
{

    /**
     * @var Engine Foil引擎
     */
    private $engine;

    /**
     * @var array 配置
     */
    private $config;

    /**
     * @var array 变量
     */
    private $assigns = [];

    /**
     * 初始化
     * @param array $config 配置
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $foil = FoilEngine::boot($this->config);
        $this->engine = $foil->engine();
    }

    /**
     * 获取底部引擎对象
     * @return Engine
     */
    public function engine()
    {
        return $this->engine;
    }

    /**
     * 变量赋值
     * @param string $name  变量名
     * @param mixed  $value 变量
     */
    public function assign($name, $value)
    {
        $this->assigns[$name] = $value;
    }

    /**
     * 返回渲染内容
     * @param string $path    模板文件路径
     * @param array  $assigns 指定变量赋值
     * @return string
     */
    public function render($path, $assigns = [])
    {
        if ($assigns) {
            foreach ($assigns as $name => $value) {
                $this->assign($name, $value);
            }
        }
        return $this->engine->render($path, $this->assigns);
    }
}
