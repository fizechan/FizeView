<?php

namespace Fize\View\Handler;

use Fize\View\ViewHandler;
use Pug\Pug as PugEngine;

/**
 * Pug
 *
 * composer require pug-php/pug
 */
class Pug implements ViewHandler
{

    /**
     * @var PugEngine Pug引擎
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
        $default_config = [
            'basedir' => './view',
            'cache'   => './cache',
            'suffix'  => 'pug'
        ];
        $config = array_merge($default_config, $config);
        $this->config = $config;
        $this->engine = new PugEngine($this->config);
    }

    /**
     * 获取底部引擎对象
     * @return PugEngine
     */
    public function engine(): PugEngine
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
        $path = $this->config['basedir'] . '/' . $path . '.' . $this->config['suffix'];

        if ($assigns) {
            foreach ($assigns as $name => $value) {
                $this->assign($name, $value);
            }
        }
        return $this->engine->render($path, $this->assigns);
    }
}
