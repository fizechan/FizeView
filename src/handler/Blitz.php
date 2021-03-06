<?php

namespace fize\view\handler;

use Blitz as BlitzEngine;
use fize\view\ViewHandler;

/**
 * Blitz
 *
 * 需要编译Blitz并启用该扩展
 * @see  http://alexeyrybak.com/blitz/blitz_en.html
 */
class Blitz implements ViewHandler
{

    /**
     * @var BlitzEngine Blitz引擎
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
    public function __construct($config = [])
    {
        $default = [
            'view'   => './view',
            'suffix' => 'tpl',
        ];
        $config = array_merge($default, $config);
        $this->config = $config;

        $this->engine = new BlitzEngine();
    }

    /**
     * 获取底部引擎对象
     * @return BlitzEngine
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
        $this->engine->load(file_get_contents($this->config['view'] . $path . '.' . $this->config['suffix']));
        if ($this->assigns) {
            $this->engine->set($this->assigns);
        }
        return $this->engine->parse();
    }
}
