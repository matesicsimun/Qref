<?php

namespace src\Repository;

use src\Interfaces\IUserRepository;
use src\Model\User;

class UserRepository implements IUserRepository
{

    public function __construct()
    {

    }

    public function saveUser(\src\Model\User $user)
    {
        $user->save();
    }

    public function getUser(int $id): User
    {
        // TODO: Implement getUser() method.
    }

    public function deleteUser(int $id)
    {
        // TODO: Implement deleteUser() method.
    }

    public function updateUser(\src\Model\User $user)
    {
        // TODO: Implement updateUser() method.
    }

    public function GetUserByUsername(string $username): User
    {
        $user = new User();
        $users = $user->loadAll("WHERE username = " . " '$username'" );

        if (count($users) === 1){
            return $users[0];
        }
    }
}