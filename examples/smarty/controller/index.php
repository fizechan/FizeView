<?php

require_once "../../../vendor/autoload.php";

use fize\view\View;

$config = [
    'cache_dir'    => '../runtime/cache/',
    'compile_dir'  => '../runtime/compile/',
    'config_dir'   => ['../config/'],
    'plugins_dir'  => [],
    'template_dir' => ['../view/'],
    'suffix'       => 'tpl'
];
$view = View::getInstance('Smarty', $config);

/**
 * @var $engine Smarty
 */
$engine = $view->engine();
$engine->assign("Name", "Fred Irving Johnathan Bradley Peppergill", true);
$view->assign("FirstName", array("John", "Mary", "James", "Henry"));
$view->assign("LastName", array("Doe", "Smith", "Johnson", "Case"));
$view->assign(
    "Class",
    array(
        array("A", "B", "C", "D"),
        array("E", "F", "G", "H"),
        array("I", "J", "K", "L"),
        array("M", "N", "O", "P")
    )
);
$view->assign(
    "contacts",
    array(
        array("phone" => "1", "fax" => "2", "cell" => "3"),
        array("phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234")
    )
);
$view->assign("option_values", array("NY", "NE", "KS", "IA", "OK", "TX"));
$view->assign("option_output", array("New York", "Nebraska", "Kansas", "Iowa", "Oklahoma", "Texas"));
$view->assign("option_selected", "NE");

$view->display('index');