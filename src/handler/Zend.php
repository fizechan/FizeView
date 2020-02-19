<?php


namespace fize\view\handler;

use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use fize\view\ViewHandler;

/**
 * Zend
 * @see https://zendframework.github.io/zend-view/php-renderer/
 * @deprecated zendframework已改名为Laminas
 * @todo 待测试
 */
class Zend implements ViewHandler
{

    /**
     * @var PhpRenderer Zend引擎
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
        $this->engine = new ViewModel(null, $this->config);
    }

    /**
     * 获取底部引擎对象
     * @return ViewModel
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
        $this->engine->setVariable($name, $value);
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
        $renderer = new PhpRenderer();
        $this->engine->setTemplate($path);
        return $renderer->render($this->engine);
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
