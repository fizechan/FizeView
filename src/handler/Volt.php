<?php


namespace fize\view\handler;

use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use fize\view\ViewHandler;

/**
 * Volt
 *
 * Volt引擎是Phalcon使用的模板引擎，由C语言编写，需要下载dll并开启该扩展
 * @see http://docs.iphalcon.cn/reference/volt.html
 * @todo 待测试
 */
class Volt implements ViewHandler
{

    /**
     * @var VoltEngine Volt引擎
     */
    private $engine;

    /**
     * @var array 配置
     */
    private $config;

    /**
     * 初始化
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        $default = [
            'view' => './view',
        ];
        $config = array_merge($default, $config);
        $this->config = $config;
        $this->engine = new VoltEngine($this->config);
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
     * @param string $name 变量名
     * @param mixed $value 变量
     */
    public function assign($name, $value)
    {
        $this->engine->setVar($name, $value);
    }

    /**
     * 返回渲染内容
     * @param string $path 模板文件路径
     * @param array $assigns 指定变量赋值
     * @return string
     */
    public function render($path, array $assigns = [])
    {
        if ($assigns) {
            foreach ($assigns as $name => $value) {
                $this->assign($name, $value);
            }
        }
        return $this->engine->compile($path);
    }

    /**
     * 显示渲染内容
     * @param string $path 模板文件路径
     * @param array $assigns 指定变量赋值
     */
    public function display($path, array $assigns = [])
    {
        echo $this->render($path, $assigns);
    }
}
