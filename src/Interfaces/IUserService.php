<?php

namespace src\Interfaces;

use src\Model\User;

interface IUserService
{
    public function saveUser(array $userData): int;

    public function checkPasswordForUser(string $username,  string $password): bool;

    public function setUserAttributes(User $user): User;

    public function loadUserByUsername(string $username): ?User;

    public function loadUserById(int $id): ?User;

    public function updateUserPassword(string $username, string $passwordNew): int;
}