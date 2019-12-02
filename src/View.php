<?php


namespace fize\view;

/**
 * 视图类
 */
class View
{

    /**
     * @var ViewHandler 模板引擎
     */
    protected static $view;

    /**
     * @var string 模板路径
     */
    protected static $path;

    /**
     * 构造方法
     *
     * 在构造方法中设置默认引擎
     * @param string $handler 处理器
     * @param array $config 参数配置
     */
    public function __construct($handler, array $config = [])
    {
        self::$view = self::getInstance($handler, $config);
    }

    /**
     * 获取底部引擎对象
     * @return mixed
     */
    public static function engine()
    {
        return self::$view->engine();
    }

    /**
     * 设置模板路径
     * @param string $path 模板路径
     */
    public static function path($path)
    {
        self::$path = $path;
    }

    /**
     * 变量赋值
     * @param string $name 变量名
     * @param mixed $value 变量
     */
    public static function assign($name, $value)
    {
        self::$view->assign($name, $value);
    }

    /**
     * 返回渲染内容
     * @param string $path 模板文件路径
     * @param array $assigns 指定变量赋值
     * @return string
     */
    public static function render($path = null, array $assigns = [])
    {
        if ($path) {
            self::path($path);
        }
        return self::$view->render(self::$path, $assigns);
    }

    /**
     * 显示渲染内容
     * @deprecated 使用render方法统一调用即可
     * @param string $path 模板文件路径
     * @param array $assigns 指定变量赋值
     */
    public static function display($path = null, array $assigns = [])
    {
        if ($path) {
            self::path($path);
        }
        self::$view->display(self::$path, $assigns);
    }

    /**
     * 取得实例
     * @param string $handler 处理器
     * @param array $config 参数配置
     * @return ViewHandler
     */
    public static function getInstance($handler, array $config = [])
    {
        $class = '\\' . __NAMESPACE__ . '\\handler\\' . $handler;
        return new $class($config);
    }

}