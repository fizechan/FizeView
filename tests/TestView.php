<?php


use Fize\View\View;
use PHPUnit\Framework\TestCase;

class TestView extends TestCase
{

    /**
     * @var bool
     */
    protected static $seriver = false;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        if(!self::$seriver) {
            self::$seriver = true;
            $cmd = 'start cmd /k "cd /d %cd%/../examples &&php -S localhost:8123"';
            $pid = popen($cmd, 'r');
            pclose($pid);
            sleep(3);  //待服务器启动
        }
    }

    public function testEngine()
    {

    }

    public function test__construct()
    {

    }

    public function testPath()
    {

    }

    public function testRender()
    {

    }

    public function testGetInstance()
    {

    }

    public function testAssign()
    {

    }

    public function testDisplay()
    {

    }
}
