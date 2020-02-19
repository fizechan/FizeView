<?php


namespace fize\view\handler;

use Config\View;
use CodeIgniter\View\Parser;
use fize\view\ViewHandler;

/**
 * CodeIgniter
 *
 * CodeIgniter4
 * @see https://codeigniter4.github.io
 * @todo 待测试
 */
class CodeIgniter implements ViewHandler
{

    /**
     * @var Parser CodeIgniter4模板引擎
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
        $this->config = $config;
        $view = new View();
        if (isset($this->config['saveData'])) {
            $view->saveData = $this->config['saveData'];
        }
        if (isset($this->config['filters'])) {
            $view->filters = $this->config['filters'];
        }
        if (isset($this->config['plugins'])) {
            $view->plugins = $this->config['plugins'];
        }
        $viewPath = isset($this->config['viewPath']) ? $this->config['viewPath'] : null;
        $this->engine = new Parser($view, $viewPath);
    }

    /**
     * 获取底部引擎对象
     * @return Parser
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
        return $this->engine->setData($assigns)->render($path);
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
