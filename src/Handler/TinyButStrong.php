<?php

namespace Fize\View\Handler;

use clsTinyButStrong;
use Fize\View\ViewHandler;

/**
 * TinyButStrong
 *
 * composer require tinybutstrong/tinybutstrong
 * @todo 视图文件尚未调整完毕
 */
class TinyButStrong implements ViewHandler
{

    /**
     * @var clsTinyButStrong TinyButStrong引擎
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
            'view'   => './view',
            'suffix' => 'htm'
        ];
        $config = array_merge($default_config, $config);
        $this->config = $config;
        $this->engine = new clsTinyButStrong($this->config);
    }

    /**
     * 获取底部引擎对象
     * @return clsTinyButStrong
     */
    public function engine(): clsTinyButStrong
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
        $GLOBALS[$name] = $value;
    }

    /**
     * 返回渲染内容
     * @param string $path    模板文件路径
     * @param array  $assigns 指定变量赋值
     * @return string
     */
    public function render(string $path, array $assigns = []): string
    {
        $path = $this->config['view'] . '/' . $path . '.' . $this->config['suffix'];
        $this->engine->LoadTemplate($path);
        if ($assigns) {
            foreach ($assigns as $name => $value) {
                $this->assign($name, $value);
            }
        }
        $this->engine->Show();
        return ob_get_clean();
    }
}
