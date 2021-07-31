<?php

namespace fize\view\handler;

use fize\view\ViewHandler;
use think\Template;

/**
 * Think
 *
 * composer require topthink/think-template
 */
class Think implements ViewHandler
{

    /**
     * @var Template Think引擎
     */
    private $engine;

    /**
     * 初始化模板
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        $default = [
            'view_path'  => './view/',
            'cache_path' => './runtime/',
        ];
        $config = array_merge($default, $config);
        $this->engine = new Template($config);
    }

    /**
     * 获取底部引擎对象
     * @return Template
     */
    public function engine(): Template
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
        $this->engine->assign([$name => $value]);
    }

    /**
     * 返回渲染内容
     * @param string $path    模板文件路径
     * @param array  $assigns 指定变量赋值
     * @return string
     */
    public function render(string $path, array $assigns = []): string
    {
        $this->engine->fetch($path, $assigns);
        return ob_get_clean();
    }
}
