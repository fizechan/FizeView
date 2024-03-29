<?php

namespace Fize\View\Handler;

use Fize\View\ViewHandler;
use Rain\Tpl;

/**
 * RainTPL
 *
 * composer require rain/raintpl
 */
class RainTPL implements ViewHandler
{

    /**
     * @var Tpl RainTPL引擎
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
        $default_config = [
            'tpl_dir'   => './view',
            'cache_dir' => './cache',
        ];
        $config = array_merge($default_config, $config);
        $this->config = $config;
        Tpl::configure($this->config);
        $this->engine = new Tpl();
    }

    /**
     * 获取底部引擎对象
     * @return Tpl
     */
    public function engine(): Tpl
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
        $this->engine->assign($name, $value);
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
        return $this->engine->draw($path, true);
    }
}
