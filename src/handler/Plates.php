<?php


namespace fize\view\handler;

use League\Plates\Engine;
use fize\view\ViewHandler;

/**
 * Plates
 * @see https://packagist.org/packages/league/plates
 * @todo 待测试
 */
class Plates implements ViewHandler
{

    /**
     * @var Engine Plates引擎
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
            'view' => './view'
        ];
        $config = array_merge($default, $config);
        $this->config = $config;
        $this->engine = new Engine($this->config['view']);
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
     * @param string $name 变量名
     * @param mixed $value 变量
     */
    public function assign($name, $value)
    {
        $this->assigns[$name] = $value;
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
        return $this->engine->render($path, $this->assigns);
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
