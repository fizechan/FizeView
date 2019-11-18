<?php


namespace fize\view\handler;

use fize\view\ViewHandler;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use fize\io\Directory;

/**
 * Twig引擎
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
    private $assigns;

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
            'path'   => './view',
            'suffix' => 'twig',
            'cache'  => './runtime'
        ];
        $config = array_merge($default, $config);
        Directory::createDirectory($config['path'], 0777, true);
        $loader = new FilesystemLoader($config['path']);
        unset($config['path']);
        $this->suffix = $config['suffix'];
        unset($config['suffix']);
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
        return $this->engine->render($path . '.' . $this->suffix, $this->assigns);
    }

    /**
     * 显示渲染内容
     * @param string $path 模板文件路径
     * @param array $assigns 指定变量赋值
     */
    public function display($path, array $assigns = [])
    {
        if ($assigns) {
            foreach ($assigns as $name => $value) {
                $this->assign($name, $value);
            }
        }
        $this->engine->display($path . '.' . $this->suffix, $this->assigns);
    }
}