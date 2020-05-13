<?php

namespace src\Repository;

use MongoDB\Driver\Exception\CommandException;
use src\Interfaces\IUserRepository;
use src\Model\User;

class UserRepository implements IUserRepository
{

    public function __construct()
    {

    }

    public function updateUser(User $user): int{
        try{
            $user->save();
        } catch (\Exception $e){
            return -1;
        }

        return 0;
    }

    public function saveUser(\src\Model\User $user): int
    {
        if($this->getUserByUsername($user->__get("Username"))){
            return -2;
        }
        try{
            $user->save();
        } catch (\Exception $e){
            return -1;
        }

        return 0;
    }

    public function getUser(int $id): User
    {
        $user = new User();
        $user->load($id);

        return $user;
    }

    public function deleteUser(int $id)
    {
        // TODO: Implement deleteUser() method.
    }


    public function GetUserByUsername(string $username): ?User
    {
        $user = new User();
        try{
            $users = $user->loadAll("WHERE username = " . " '$username'" );
            if (!empty($users)){
                return $users[0];
            }
            return null;
        } catch (\Exception $e){

        }
    }
}