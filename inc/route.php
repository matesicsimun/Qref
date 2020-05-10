<?php

use src\Routes\AbstractRoute;
use src\Routes\DefaultRoute;

AbstractRoute::register("index", new DefaultRoute("index", array(
    "controller"=>"IndexController",
    "action"=>"displayHomePage"
)));

AbstractRoute::register("account_info", new DefaultRoute("account_info", array(
    "controller"=>"UserController",
    "action"=>"showAccountInfo"
)));

AbstractRoute::register("login", new DefaultRoute("login", array(
    "controller"=>"UserController",
    "action"=>"loginUser"
)));

AbstractRoute::register("logout", new DefaultRoute("logout", array(
    "controller"=>"UserController",
    "action"=>"logoutUser"
)));

AbstractRoute::register("change_password", new DefaultRoute("change_password", array(
    "controller"=>"UserController",
    "action"=>"changePassword"
)));

AbstractRoute::register("e404", new DefaultRoute("error/404", array(
        "controller" => "NotFoundController",
        "action" => "display"
    ))
);

AbstractRoute::register("register", new DefaultRoute("register", array(
    "controller"=>"UserController",
    "action"=>"registerUser"
)));

