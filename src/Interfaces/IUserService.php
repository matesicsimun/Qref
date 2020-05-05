<?php

namespace src\Interfaces;

use src\Model\User;

interface IUserService
{
    public function createUser(array $userData): ?User;

    public function checkPassword(string $password, string $storedPassword): bool;

    public function setUserAttributes(User $user): User;
}