<?php

require_once "../../../vendor/autoload.php";

use Fize\View\View;

$config = [
    'cache_dir'    => '../runtime/cache/',
    'compile_dir'  => '../runtime/compile/',
    'config_dir'   => ['../config/'],
    'plugins_dir'  => [],
    'template_dir' => ['../view/'],
    'suffix'       => 'tpl'
];
$view = new View('Smarty', $config);

/**
 * @var $engine Smarty
 */
$engine = View::engine();
$engine->assign("Name", "Fred Irving Johnathan Bradley Peppergill", true);
$view->assign("FirstName", ["John", "Mary", "James", "Henry"]);
$view->assign("LastName", ["Doe", "Smith", "Johnson", "Case"]);
$view->assign(
    "Class",
    [
        ["A", "B", "C", "D"],
        ["E", "F", "G", "H"],
        ["I", "J", "K", "L"],
        ["M", "N", "O", "P"]
    ]
);
$view->assign(
    "contacts",
    [
        ["phone" => "1", "fax" => "2", "cell" => "3"],
        ["phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234"]
    ]
);
$view->assign("option_values", ["NY", "NE", "KS", "IA", "OK", "TX"]);
$view->assign("option_output", ["New York", "Nebraska", "Kansas", "Iowa", "Oklahoma", "Texas"]);
$view->assign("option_selected", "NE");

echo View::render('index');
