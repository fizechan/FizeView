<?php


namespace fize\view\handler;

use clsTinyButStrong;
use fize\view\ViewHandler;

/**
 * TinyButStrong
 * @see https://www.tinybutstrong.com/
 * @todo 待测试
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
        $default = [
            'view' => './view',
        ];
        $config = array_merge($default, $config);
        $this->config = $config;
        $this->engine = new clsTinyButStrong($this->config);
    }

    /**
     * 获取底部引擎对象
     * @return clsTinyButStrong
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
        $this->engine->MergeBlock($name, $value);
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
        $this->engine->Show();
        return ob_get_clean();
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
        $this->engine->Show();
    }
}
