<?php


namespace fize\view\handler;

use Dwoo\Core;
use Dwoo\Data;
use Dwoo\Template\File;
use fize\view\ViewHandler;

/**
 * Dwoo
 * @see http://dwoo.org/
 * @deprecated dwoo已不再维护
 * @todo 待测试
 */
class Dwoo implements ViewHandler
{

    /**
     * @var Core Dwoo模板引擎
     */
    private $engine;

    /**
     * @var array 配置
     */
    private $config;

    /**
     * @var Data 模板数据
     */
    private $data;

    /**
     * 初始化
     * @param array $config 配置
     */
    public function __construct(array $config = [])
    {
        $default = [
            'compileDir' => null,
            'cacheDir'   => null
        ];
        $config = array_merge($default, $config);
        $this->config = $config;
        $this->engine = new Core($this->config['compileDir'], $this->config['cacheDir']);
        $this->data = new Data();
    }

    /**
     * 获取底部引擎对象
     * @return Core
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
        $this->data->assign($name, $value);
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
            $this->data->setData($assigns);
        }
        $tpl = new File($path);
        return $this->engine->get($tpl, $this->data);
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
