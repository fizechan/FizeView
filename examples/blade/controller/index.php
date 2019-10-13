<?php

require_once "../../../vendor/autoload.php";

use fize\view\View;

$config = [
    'path'  => '../view/',
    'cache' => '../runtime/',
];
$view = View::getInstance('Blade', $config);

$view->assign('title', '这是标题！~');

$list = [
    [
        'id'      => 1,
        'title'   => '厉害了我的国1',
        'content' => '厉害了厉害了！~1'
    ],
    [
        'id'      => 2,
        'title'   => '厉害了我的国2',
        'content' => '厉害了厉害了！~2'
    ],
    [
        'id'      => 3,
        'title'   => '厉害了我的国3',
        'content' => '厉害了厉害了！~3'
    ]
];
$view->assign('list', $list);

$news = [
    [
        'id'    => 4,
        'title' => '厉害了我的国4'
    ],
    [
        'id'    => 5,
        'title' => '厉害了我的国5'
    ]
];
$view->assign('news', $news);

$view->display('index');