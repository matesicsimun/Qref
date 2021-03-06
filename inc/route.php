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

AbstractRoute::register("e404", new DefaultRoute("e404", array(
        "controller" => "NotFoundController",
        "action" => "display"
    ))
);

AbstractRoute::register("register", new DefaultRoute("register", array(
    "controller"=>"UserController",
    "action"=>"registerUser"
)));

AbstractRoute::register("quiz_create", new DefaultRoute("quiz_create", array(
    "controller"=>"QuizController",
    "action"=>"createQuiz"
)));

AbstractRoute::register("quiz_view", new DefaultRoute("quiz_view", array(
    "controller"=>"QuizController",
    "action"=>"showQuizzes"
)));

AbstractRoute::register("quiz_solve", new DefaultRoute("quiz_solve", array(
    "controller"=>"QuizController",
    "action"=>"solveQuiz"
)));

AbstractRoute::register("quiz_statistics", new DefaultRoute("quiz_statistics", array(
    "controller"=>"StatisticsController",
    "action"=>"showStatistics"
)));

AbstractRoute::register("quiz_edit", new DefaultRoute("quiz_edit", array(
    "controller"=>"QuizController",
    "action"=>"editQuiz"
)));

AbstractRoute::register("save_comment", new DefaultRoute("save_comment", array(
    "controller"=>"CommentController",
    "action"=>"saveComment"
)));


AbstractRoute::register("quiz_details", new DefaultRoute("quiz_details", array(
    "controller"=>"QuizController",
    "action"=>"showQuizDetails"
)));


