<?php


namespace fize\view\handler;

use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Resolver\AggregateResolver;
use Laminas\View\Resolver\TemplatePathStack;
use Laminas\View\Resolver\RelativeFallbackResolver;
use fize\view\ViewHandler;

/**
 * Laminas
 * composer require laminas/laminas-view
 * composer require laminas/laminas-servicemanager
 * zendframework进入Linux基金会后改名为Laminas
 * @deprecated 不建议使用
 */
class Laminas implements ViewHandler
{

    /**
     * @var array 配置
     */
    private $config;

    /**
     * @var PhpRenderer Zend引擎
     */
    private $engine;

    /**
     * @var ViewModel 视图模型
     */
    private $viewModel;

    /**
     * 初始化
     * @param array $config 配置
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $this->engine = new PhpRenderer($this->config);
        $this->viewModel = new ViewModel(null, $this->config);

        $resolver = new AggregateResolver();
        $stack = new TemplatePathStack([
            'script_paths'   => $this->config['script_paths'],
            'default_suffix' => $this->config['default_suffix']
        ]);
        $resolver->attach($stack);
        $resolver->attach(new RelativeFallbackResolver($stack));
        $this->engine->setResolver($resolver);
    }

    /**
     * 获取底部引擎对象
     * @return PhpRenderer
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
        $this->viewModel->setVariable($name, $value);
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
        $this->viewModel->setTemplate($path);
        return $this->engine->render($this->viewModel);
    }
}
