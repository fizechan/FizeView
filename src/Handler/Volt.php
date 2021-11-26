<?php

namespace Fize\View\Handler;

use Fize\View\ViewHandler;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

/**
 * Volt
 *
 * Volt引擎是Phalcon使用的模板引擎，由C语言编写，需要安装并开启该扩展
 * @see https://docs.phalcon.io/4.0/zh-cn/installation
 */
class Volt implements ViewHandler
{

    private $view;

    /**
     * @var VoltEngine Volt引擎
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
    public function __construct(array $config = [])
    {
        $default = [
            'view'   => './view',
            'suffix' => 'volt',
            'path'   => './cache'
        ];
        $config = array_merge($default, $config);
        $this->config = $config;
        $this->view = new View();
        $this->engine = new VoltEngine($this->view);
        $this->engine->setOptions($this->config);
    }

    /**
     * 获取底部引擎对象
     * @return VoltEngine
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
    public function assign(string $name, $value)
    {
        $this->assigns[$name] = $value;
    }

    /**
     * 返回渲染内容
     * @param string $path    模板文件路径
     * @param array  $assigns 指定变量赋值
     * @return string
     */
    public function render(string $path, array $assigns = []): string
    {
        $path = $this->config['view'] . '/' . $path . '.' . $this->config['suffix'];

        if ($assigns) {
            foreach ($assigns as $name => $value) {
                $this->assign($name, $value);
            }
        }
        return $this->engine->render($path, $this->assigns);
    }
}
