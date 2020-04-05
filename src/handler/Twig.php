<?php


namespace fize\view\handler;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use fize\view\ViewHandler;

/**
 * Twig
 */
class Twig implements ViewHandler
{

    /**
     * @var Environment Twig引擎
     */
    private $engine;

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
            'cache' => './runtime'
        ];
        $config = array_merge($default, $config);
        $loader = new FilesystemLoader($config['view']);
        unset($config['view']);
        $this->engine = new Environment($loader, $config);
    }

    /**
     * 获取底层引擎对象
     * @return mixed
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
        return $this->engine->render($path . '.twig', $this->assigns);
    }
}
