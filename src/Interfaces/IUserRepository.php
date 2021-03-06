<?php


namespace src\Interfaces;
use src\Model\User;

interface IUserRepository
{
    public function saveUser(User $user):int;

    public function updateUser(User $user): int;

    public function getUser(int $id): ?User;

    public function GetUserByUsername(string $username): ?User;

    public function deleteUser(int $id);

}