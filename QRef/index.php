<?php

$controller = null;


switch (get("action")) {
    case "register":
        $controller = new \src\Controller\RegisterController($_POST);
        break;
    default:
        $controller = new controller\IndexController(get("letter"));
}

$controller->doAction();
