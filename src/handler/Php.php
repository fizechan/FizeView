<?php

namespace fize\view\handler;

use fize\view\ViewHandler;

/**
 * PHP
 */
class Php implements ViewHandler
{

    /**
     * @var array 配置
     */
    private $config;

    /**
     * @var array 变量
     */
    private $assigns;

    /**
     * 初始化模板
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        $default = [
            'view'   => './view',
            'suffix' => 'php'
        ];
        $this->config = array_merge($default, $config);
    }

    /**
     * 获取底部引擎对象
     * @return Php
     */
    public function engine(): Php
    {
        return $this;
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
        extract($this->assigns);
        $full_path = $this->config['view'] . '/' . $path . '.' . $this->config['suffix'];
        require_once $full_path;
        return ob_get_clean();
    }
}
