<?php


namespace src\Interfaces;
use src\Model\User;

interface IUserRepository
{
    public function saveUser(User $user);

    public function getUser(int $id): User;

    public function deleteUser(int $id);

    public function updateUser(User $user);
}