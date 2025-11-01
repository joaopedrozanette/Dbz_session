<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/model/goku.php';
require_once __DIR__ . '/controller/gokucontroller.php';

$route = $_GET['r'] ?? 'goku/index';
list($ctrl, $act) = array_pad(explode('/', $route, 2), 2, 'index');

$ctrlClass = ucfirst($ctrl) . 'Controller';
if (!class_exists($ctrlClass)) { die('Controller não encontrado'); }

$controller = new $ctrlClass();
if (!method_exists($controller, $act)) { die('Ação não encontrada'); }
$controller->$act();
