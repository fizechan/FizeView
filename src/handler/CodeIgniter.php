<?php

namespace fize\view\handler;

use CodeIgniter\Autoloader\Autoloader;
use CodeIgniter\Autoloader\FileLocator;
use CodeIgniter\Log\Logger;
use CodeIgniter\View\Parser;
use fize\view\ViewHandler;

/**
 * CodeIgniter
 * CodeIgniter4
 * @deprecated 功能太弱，实现得太不优美了，放弃支持！
 * @see https://codeigniter4.github.io
 */
class CodeIgniter implements ViewHandler
{

    /**
     * @var Parser CodeIgniter4模板引擎
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
    public function __construct($config = [])
    {
        defined('CI_DEBUG') || define('CI_DEBUG', 1);
        if (! defined('APPPATH'))
        {
            define('APPPATH', realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR);
        }
        if (! defined('SYSTEMPATH'))
        {
            define('SYSTEMPATH', realpath(__DIR__ . '/../../system') . DIRECTORY_SEPARATOR);
        }

        $this->config = $config;
        $view = new ConfigView();
        if (isset($this->config['saveData'])) {
            $view->saveData = $this->config['saveData'];
        }
        if (isset($this->config['filters'])) {
            $view->filters = $this->config['filters'];
        }
        if (isset($this->config['plugins'])) {
            $view->plugins = $this->config['plugins'];
        }
        $viewPath = isset($this->config['viewPath']) ? $this->config['viewPath'] : null;
        $this->engine = new Parser($view, $viewPath, new FileLocator(new Autoloader()), true, new Logger(new ConfigLogger()));
    }

    /**
     * 获取底部引擎对象
     * @return Parser
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
        $this->engine->setVar($name, $value);
    }

    /**
     * 返回渲染内容
     * @param string $path    模板文件路径
     * @param array  $assigns 指定变量赋值
     * @return string
     */
    public function render($path, $assigns = [])
    {
        $options = isset($this->config['options']) ? $this->config['options'] : null;
        return $this->engine->setData($assigns)->render($path, $options);
    }

    /**
     * 显示渲染内容
     * @param string $path    模板文件路径
     * @param array  $assigns 指定变量赋值
     */
    public function display($path, $assigns = [])
    {
        echo $this->render($path, $assigns);
    }
}


class ConfigView
{

    public $saveData = true;

    public $filters = [
        'abs'            => '\abs',
        'capitalize'     => '\CodeIgniter\View\Filters::capitalize',
        'date'           => '\CodeIgniter\View\Filters::date',
        'date_modify'    => '\CodeIgniter\View\Filters::date_modify',
        'default'        => '\CodeIgniter\View\Filters::default',
        //'esc'            => '\CodeIgniter\View\Filters::esc',
        'excerpt'        => '\CodeIgniter\View\Filters::excerpt',
        'highlight'      => '\CodeIgniter\View\Filters::highlight',
        'highlight_code' => '\CodeIgniter\View\Filters::highlight_code',
        'limit_words'    => '\CodeIgniter\View\Filters::limit_words',
        'limit_chars'    => '\CodeIgniter\View\Filters::limit_chars',
        'local_currency' => '\CodeIgniter\View\Filters::local_currency',
        'local_number'   => '\CodeIgniter\View\Filters::local_number',
        'lower'          => '\strtolower',
        'nl2br'          => '\CodeIgniter\View\Filters::nl2br',
        'number_format'  => '\number_format',
        'prose'          => '\CodeIgniter\View\Filters::prose',
        'round'          => '\CodeIgniter\View\Filters::round',
        'strip_tags'     => '\strip_tags',
        'title'          => '\CodeIgniter\View\Filters::title',
        'upper'          => '\strtoupper',
    ];

    public $plugins = [
        'current_url'       => '\CodeIgniter\View\Plugins::currentURL',
        'previous_url'      => '\CodeIgniter\View\Plugins::previousURL',
        'mailto'            => '\CodeIgniter\View\Plugins::mailto',
        'safe_mailto'       => '\CodeIgniter\View\Plugins::safeMailto',
        'lang'              => '\CodeIgniter\View\Plugins::lang',
        'validation_errors' => '\CodeIgniter\View\Plugins::validationErrors',
        'route'             => '\CodeIgniter\View\Plugins::route',
        'siteURL'           => '\CodeIgniter\View\Plugins::siteURL',
    ];
}


class ConfigLogger
{
    public $threshold = 3;

    public $path = '';

    public $dateFormat = 'Y-m-d H:i:s';

    public $handlers = [
        'CodeIgniter\Log\Handlers\FileHandler' => [
            'handles'         => [
                'critical',
                'alert',
                'emergency',
                'debug',
                'error',
                'info',
                'notice',
                'warning',
            ],
            'fileExtension'   => '',
            'filePermissions' => 0644,
        ],
    ];
}
