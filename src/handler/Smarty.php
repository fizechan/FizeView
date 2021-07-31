<?php

namespace fize\view\handler;

use fize\view\ViewHandler;
use Smarty as SmartyEngine;

/**
 * Smarty
 *
 * composer require smarty/smarty
 */
class Smarty implements ViewHandler
{

    /**
     * @var SmartyEngine Smarty引擎
     */
    private $engine;

    /**
     * @var array 配置
     */
    private $config;

    /**
     * @var string 模板后缀
     */
    private $suffix;

    /**
     * 初始化模板
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        $default = [
            'suffix'       => 'tpl',
            'debugging'    => false,
            'caching'      => 0,
            'cache_dir'    => './runtime/cache/',
            'compile_dir'  => './runtime/compile/',
            'config_dir'   => ['./config/'],
            'plugins_dir'  => [],
            'template_dir' => ['./view/']
        ];
        $config = array_merge($default, $config);
        $this->config = $config;

        $this->suffix = $config['suffix'];
        unset($config['suffix']);

        $this->engine = new SmartyEngine();
        foreach ($config as $key => $value) {
            $this->engine->$key = $value;
        }
    }

    /**
     * 获取底部引擎对象
     * @return SmartyEngine
     */
    public function engine(): SmartyEngine
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
        $this->engine->assign($name, $value);
    }

    /**
     * 返回渲染内容
     * @param string $path    模板文件路径
     * @param array  $assigns 指定变量赋值
     * @return string
     */
    public function render(string $path, array $assigns = []): string
    {
        if ($assigns) {
            foreach ($assigns as $name => $value) {
                $this->assign($name, $value);
            }
        }
        return $this->engine->fetch($path . '.' . $this->suffix);
    }
}
