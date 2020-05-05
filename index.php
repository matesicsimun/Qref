<?php

require_once './lib/global.php';

session_start();

$controller = null;

$userService = new \src\Service\UserService();
$userRepository = new \src\Repository\UserRepository();


switch (get("action")) {
    case "register":
        $controller = new \src\Controller\RegisterController($userService, $userRepository, $_POST);
        break;
    case "login":
        $controller = new \src\Controller\LoginController($userRepository, $userService, $_POST);
        break;
    default:
        $controller = new \src\Controller\IndexController();
        break;
}

$controller->doAction();

