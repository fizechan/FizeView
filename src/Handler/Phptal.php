<?php

namespace Fize\View\Handler;

use Fize\View\ViewHandler;
use PHPTAL as PhptalEngine;

/**
 * Phptal
 *
 * composer require phptal/phptal
 */
class Phptal implements ViewHandler
{

    /**
     * @var PhptalEngine Phptal引擎
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
            'cache'  => './cache',
            'suffix' => 'xhtml'
        ];
        $config = array_merge($default, $config);
        $this->config = $config;
        $this->engine = new PhptalEngine();

        $this->engine->setPhpCodeDestination($this->config['cache']);
    }

    /**
     * 获取底部引擎对象
     * @return PhptalEngine
     */
    public function engine(): PhptalEngine
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
        $this->engine->setTemplate($path);
        foreach ($this->assigns as $name => $value) {
            $this->engine->set($name, $value);
        }
        return $this->engine->execute();
    }
}
