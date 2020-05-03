<?php

namespace src\Interfaces;

use src\Model\User;

interface IUserService
{
    public function saveUser(array $userData): int;

    public function deleteUser(int $id): int;

    public function editUser(array $userData): int;

    public function getUser(int $id): User;

    public function getUsers(): array;
}