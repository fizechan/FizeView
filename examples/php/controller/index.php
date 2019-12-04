<?php

require_once "../../../vendor/autoload.php";

use fize\view\View;

$config = [
    'view'   => '../view',
];
$view = View::getInstance('Php', $config);
$view->assign('name', '陈峰展');

//$html = $view->render('index');
//echo $html;

$view->display('index');