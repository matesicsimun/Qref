<?php

use src\Service\ServiceContainer;
use src\Service\UserService;

$userRepository = new \src\Repository\UserRepository();
ServiceContainer::register("UserService", new UserService($userRepository));