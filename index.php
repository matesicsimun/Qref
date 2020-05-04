<?php

require_once './lib/global.php';

$controller = null;

$userService = new \src\Service\UserService();
$userRepository = new \src\Repository\UserRepository();

switch (get("action")) {
    case "register":
        $controller = new \src\Controller\RegisterController( $userService, $userRepository, $_POST);
        break;
}

$controller->doAction();

