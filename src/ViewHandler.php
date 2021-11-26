<?php

namespace Fize\View;

/**
 * 视图接口
 */
interface ViewHandler
{

    /**
     * 构造
     * @param array $config 配置
     */
    public function __construct(array $config = []);

    /**
     * 获取底部引擎对象
     * @return mixed
     */
    public function engine();

    /**
     * 变量赋值
     * @param string $name  变量名
     * @param mixed  $value 变量
     */
    public function assign(string $name, $value);

    /**
     * 返回渲染内容
     * @param string $path    模板文件路径
     * @param array  $assigns 指定变量赋值
     * @return string
     */
    public function render(string $path, array $assigns = []): string;
}
