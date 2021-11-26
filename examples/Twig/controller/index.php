<?php

require_once "../../../vendor/autoload.php";

use Fize\View\View;

$config = [
    'view'  => '../view',
    'cache' => '../runtime',
    'debug' => true
];

new View('Twig', $config);

$assigns = ['data' => ['name' => 'evai', 'mobile' => 12345678910]];

echo View::render('index', $assigns);
