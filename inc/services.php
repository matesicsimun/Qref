<?php

use src\Service\ServiceContainer;
use src\Service\UserService;

ServiceContainer::register("UserService", new UserService());