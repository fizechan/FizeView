<?php

require_once "../../../vendor/autoload.php";

use fize\view\View;

$config = [
    'path'   => '../view',
    'cache' => '../runtime',
    'debug'  => true
];
$view = View::getInstance('Twig', $config);

$assigns = ['data' => ['name' => 'evai', 'mobile' => 12345678910]];

$view->display('index', $assigns);