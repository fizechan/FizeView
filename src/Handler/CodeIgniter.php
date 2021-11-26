<?php

namespace Fize\View\Handler;

use CodeIgniter\Autoloader\Autoloader;
use CodeIgniter\Autoloader\FileLocator;
use CodeIgniter\Log\Logger;
use CodeIgniter\View\Parser;
use Fize\View\ViewHandler;
use InvalidArgumentException;
use Laminas\Escaper\Escaper;

/**
 * CodeIgniter
 *
 * composer require codeigniter4/framework
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
    public function __construct(array $config = [])
    {
        defined('CI_DEBUG') || define('CI_DEBUG', 1);
        if (!defined('APPPATH')) {
            define('APPPATH', realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR);
        }
        if (!defined('SYSTEMPATH')) {
            define('SYSTEMPATH', realpath(__DIR__ . '/../../system') . DIRECTORY_SEPARATOR);
        }

        $this->config = $config;

        $config_view = [
            'saveData' => true,
            'filters'  => [
                'abs'            => '\abs',
                'capitalize'     => '\CodeIgniter\View\Filters::capitalize',
                'date'           => '\CodeIgniter\View\Filters::date',
                'date_modify'    => '\CodeIgniter\View\Filters::date_modify',
                'default'        => '\CodeIgniter\View\Filters::default',
                'esc'            => '\fize\view\handler\CodeIgniter::esc',  // 原esc方法无法直接使用，故在此重新实现
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
            ],

            'plugins' => [
                'current_url'       => '\CodeIgniter\View\Plugins::currentURL',
                'previous_url'      => '\CodeIgniter\View\Plugins::previousURL',
                'mailto'            => '\CodeIgniter\View\Plugins::mailto',
                'safe_mailto'       => '\CodeIgniter\View\Plugins::safeMailto',
                'lang'              => '\CodeIgniter\View\Plugins::lang',
                'validation_errors' => '\CodeIgniter\View\Plugins::validationErrors',
                'route'             => '\CodeIgniter\View\Plugins::route',
                'siteURL'           => '\CodeIgniter\View\Plugins::siteURL',
            ]
        ];
        if (isset($this->config['view']['saveData'])) {
            $config_view['saveData'] = $this->config['view']['saveData'];
        }
        if (isset($this->config['view']['filters'])) {
            $config_view['filters'] = array_merge($config_view['filters'], $this->config['view']['filters']);
        }
        if (isset($this->config['view']['plugins'])) {
            $config_view['plugins'] = array_merge($config_view['plugins'], $this->config['view']['plugins']);
        }
        $config_view = (object)$config_view;

        $viewPath = $this->config['viewPath'] ?? null;

        $config_logger = [
            'threshold' => 3,

            'path' => '',

            'dateFormat' => 'Y-m-d H:i:s',

            'handlers' => [
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
            ]
        ];
        $config_logger = (object)$config_logger;

        $this->engine = new Parser($config_view, $viewPath, new FileLocator(new Autoloader()), true, new Logger($config_logger));
    }

    /**
     * 获取底部引擎对象
     * @return Parser
     */
    public function engine(): Parser
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
        $this->engine->setVar($name, $value);
    }

    /**
     * 返回渲染内容
     * @param string $path    模板文件路径
     * @param array  $assigns 指定变量赋值
     * @return string
     */
    public function render(string $path, array $assigns = []): string
    {
        $options = $this->config['options'] ?? null;
        return $this->engine->setData($assigns)->render($path, $options);
    }

    /**
     * ESC过滤器
     * @param mixed  $data
     * @param string $context
     * @param null   $encoding
     * @return array|string
     */
    public static function esc($data, string $context = 'html', $encoding = null)
    {
        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                $value = esc($value, $context);
            }
        }

        if (is_string($data)) {
            $context = strtolower($context);

            // Provide a way to NOT escape data since
            // this could be called automatically by
            // the View library.
            if (empty($context) || $context === 'raw') {
                return $data;
            }

            if (!in_array($context, ['html', 'js', 'css', 'url', 'attr'])) {
                throw new InvalidArgumentException('Invalid escape context provided.');
            }

            if ($context === 'attr') {
                $method = 'escapeHtmlAttr';
            } else {
                $method = 'escape' . ucfirst($context);
            }

            static $escaper;
            if (!$escaper) {
                $escaper = new Escaper($encoding);
            }

            if ($encoding && $escaper->getEncoding() !== $encoding) {
                $escaper = new Escaper($encoding);
            }

            $data = $escaper->$method($data);
        }

        return $data;
    }
}
