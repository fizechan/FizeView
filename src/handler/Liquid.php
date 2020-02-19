<?php


namespace fize\view\handler;

use Liquid\Template;
use fize\view\ViewHandler;

/**
 * Liquid
 * @see https://github.com/harrydeluxe/php-liquid
 * @todo 待测试
 */
class Liquid implements ViewHandler
{

    /**
     * @var Template Liquid引擎
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
            'view'  => './view',
            'cache' => './cache'
        ];
        $config = array_merge($default, $config);
        $this->config = $config;
        $this->engine = new Template($this->config['view']);
    }

    /**
     * 获取底部引擎对象
     * @return Template
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
        $this->engine->parse(file_get_contents($this->config['view'] . DIRECTORY_SEPARATOR . $path));
        return $this->engine->render($assigns);
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
