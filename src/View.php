<?php

namespace fize\view;

/**
 * 视图
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
     * 构造
     * @param string $handler 处理器
     * @param array  $config  参数配置
     */
    public function __construct(string $handler, array $config = [])
    {
        self::$view = ViewFactory::create($handler, $config);
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
    public static function path(string $path)
    {
        self::$path = $path;
    }

    /**
     * 变量赋值
     * @param string $name  变量名
     * @param mixed  $value 变量
     */
    public static function assign(string $name, $value)
    {
        self::$view->assign($name, $value);
    }

    /**
     * 返回渲染内容
     * @param string|null $path    模板文件路径
     * @param array       $assigns 指定变量赋值
     * @return string
     */
    public static function render(string $path = null, array $assigns = []): string
    {
        if ($path) {
            self::path($path);
        }
        return self::$view->render(self::$path, $assigns);
    }
}
