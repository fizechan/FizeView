<?php

namespace fize\view\handler;

use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;
use fize\view\ViewHandler;

/**
 * Mustache
 *
 * composer require mustache/mustache
 */
class Mustache implements ViewHandler
{

    /**
     * @var Mustache_Engine Mustache引擎
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
        $default = [
            'view'  => './view',
            'cache' => './cache'
        ];
        $config = array_merge($default, $config);
        $this->config = $config;

        $engine_config = [
            'cache'  => $this->config['cache'],
            'loader' => new Mustache_Loader_FilesystemLoader($this->config['view'])
        ];
        $this->engine = new Mustache_Engine($engine_config);
    }

    /**
     * 获取底部引擎对象
     * @return Mustache_Engine
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
        $tpl = $this->engine->loadTemplate($path);
        return $tpl->render($this->assigns);
    }
}
