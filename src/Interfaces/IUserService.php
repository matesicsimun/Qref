<?php

namespace src\Interfaces;

use src\Model\User;

interface IUserService
{
    public function createUser(array $userData): User;
}