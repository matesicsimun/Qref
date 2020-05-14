<?php

use src\Repository\ChoiceRepository;
use src\Repository\QuestionRepository;
use src\Service\ChoiceService;
use src\Service\QuizService;
use src\Service\ServiceContainer;
use src\Service\UserService;

$userRepository = new \src\Repository\UserRepository();
ServiceContainer::register("UserService", new UserService($userRepository));

$quizRepository = new \src\Repository\QuizRepository();
ServiceContainer::register("QuizService", new QuizService($quizRepository));

$questionRepository = new QuestionRepository();
ServiceContainer::register("QuestionService", new \src\Service\QuestionService($questionRepository));

$choiceRepository = new ChoiceRepository();
ServiceContainer::register("ChoiceService", new ChoiceService($choiceRepository));

$statisticsRepository = new \src\Repository\StatisticsRepository();
ServiceContainer::register("StatisticsService", new \src\Service\StatisticsService($statisticsRepository));