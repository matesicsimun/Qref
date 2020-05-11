<?php

use src\Service\QuizService;
use src\Service\ServiceContainer;
use src\Service\UserService;

$userRepository = new \src\Repository\UserRepository();
ServiceContainer::register("UserService", new UserService($userRepository));

$quizRepository = new \src\Repository\QuizRepository();
ServiceContainer::register("QuizService", new QuizService($quizRepository));

