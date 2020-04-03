<?php

require_once "../../../vendor/autoload.php";

use fize\view\View;

$config = [
    'view'   => '../view',
    'suffix' => 'tpl'
];

new View('Php', $config);
View::assign('name', '陈峰展');
echo View::render('index');
