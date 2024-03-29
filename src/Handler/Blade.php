<?php

namespace Fize\View\Handler;

use Fize\View\ViewHandler;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;

/**
 * Blade
 *
 * composer require illuminate/view
 */
class Blade implements ViewHandler
{

    /**
     * @var Factory Blade引擎
     */
    private $engine;

    /**
     * @var array 变量
     */
    private $assigns = [];

    /**
     * @var Container 容器
     */
    protected $container;

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
        $default_config = [
            'view'  => './view',
            'cache' => './runtime'
        ];
        $config = array_merge($default_config, $config);
        $config['view'] = is_array($config['view']) ? $config['view'] : [$config['view']];
        $this->config = $config;

        $this->container = new Container();

        $this->registerFilesystem();
        $this->registerEvents(new Dispatcher());
        $this->registerEngineResolver();
        $this->registerViewFinder();
        $this->engine = $this->registerFactory();
    }

    /**
     * 注册文件系统
     */
    protected function registerFilesystem()
    {
        $this->container->singleton('files', function () {
            return new Filesystem();
        });
    }

    /**
     * 注册事件处理器
     * @param Dispatcher $events 事件处理器
     */
    protected function registerEvents(Dispatcher $events)
    {
        $this->container->singleton('events', function () use ($events) {
            return $events;
        });
    }

    /**
     * 注册引擎解析器
     */
    protected function registerEngineResolver()
    {
        $me = $this;
        $this->container->singleton('view.engine.resolver', function () use ($me) {
            $resolver = new EngineResolver();
            foreach (['php', 'blade'] as $engine) {
                $me->{'register' . ucfirst($engine) . 'Engine'}($resolver);
            }
            return $resolver;
        });
    }

    /**
     * 注册PHP引擎
     * @param EngineResolver $resolver 引擎注册器
     */
    protected function registerPhpEngine(EngineResolver $resolver)
    {
        $resolver->register('php', function () {
            return new PhpEngine();
        });
    }

    /**
     * 注册Blade引擎
     * @param EngineResolver $resolver 引擎注册器
     */
    protected function registerBladeEngine(EngineResolver $resolver)
    {
        $me = $this;
        $app = $this->container;
        $this->container->singleton('blade.compiler', function ($app) use ($me) {
            $cache = $me->config['cache'];
            return new BladeCompiler($app['files'], $cache);
        });
        $resolver->register('blade', function () use ($app) {
            return new CompilerEngine($app['blade.compiler']);
        });
    }

    /**
     * 注册视图查询器
     */
    protected function registerViewFinder()
    {
        $me = $this;
        $this->container->singleton('view.finder', function ($app) use ($me) {
            $paths = $me->config['view'];
            return new FileViewFinder($app['files'], $paths);
        });
    }

    /**
     * 注册引擎
     * @return Factory
     */
    protected function registerFactory(): Factory
    {
        $resolver = $this->container['view.engine.resolver'];
        $finder = $this->container['view.finder'];
        $env = new Factory($resolver, $finder, $this->container['events']);
        $env->setContainer($this->container);
        return $env;
    }

    /**
     * 获取底部引擎对象
     * @return Factory
     */
    public function engine(): Factory
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
        $this->assigns[$name] = $value;
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
        return $this->engine->make($path, $this->assigns)->render();
    }
}
