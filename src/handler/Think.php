<?php


namespace fize\view\handler;

use fize\view\ViewHandler;
use think\Template;

/**
 * Think
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
     * @return mixed
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
        $this->engine->assign([$name => $value]);
    }

    /**
     * 返回渲染内容
     * @param string $path 模板文件路径
     * @param array $assigns 指定变量赋值
     * @return string
     */
    public function render($path, array $assigns = [])
    {
        $this->engine->fetch($path, $assigns);
        return ob_get_clean();
    }

    /**
     * 显示渲染内容
     * @param string $path 模板文件路径
     * @param array $assigns 指定变量赋值
     */
    public function display($path, array $assigns = [])
    {
        $this->engine->fetch($path, $assigns);
    }
}