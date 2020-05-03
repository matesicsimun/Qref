<?php


use src\Model\User;

interface IUserRepository
{
    public function saveUser(User $user);

    public function getUser(int $id);

    public function deleteUser(int $id);

    public function updateUser(User $user);
}