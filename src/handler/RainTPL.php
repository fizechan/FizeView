<?php


namespace fize\view\handler;

use Rain\Tpl;
use fize\view\ViewHandler;

/**
 * RainTPL
 * @see https://github.com/feulf/raintpl3/wiki/Documentation-for-web-designers
 * @todo 待测试
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
        $this->config = $config;
        Tpl::configure($this->config);
        $this->engine = new Tpl();
    }

    /**
     * 获取底部引擎对象
     * @return Tpl
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
        $this->engine->assign($name, $value);
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
        return $this->engine->draw($path, true);
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
        $this->engine->draw($path);
    }
}
