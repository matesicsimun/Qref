<?php

namespace src\Model;

use src\Model\AbstractClasses\AbstractDBModel;

/**
 * Class User
 * Models a user in the system.
 * @package src\Model
 */
class User extends AbstractDBModel
{
    private int $id;

    private string $name;

    private string $surname;

    private string $birthDate;

    private string $email;

    private string $passwordHash;

    private array $quizes;

    /**
     * @return array
     */
    public function getQuizes(): array
    {
        return $this->quizes;
    }

    /**
     * @param array $quizes
     */
    public function setQuizes(array $quizes): void
    {
        $this->quizes = $quizes;
    }



    public function setId(int $id){
        $this->id = $id;
    }

    public function getId() :int{
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate(string $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @param string $passwordHash
     */
    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }




    public function getPrimaryKeyColumn() : string
    {
        return "Id";
    }

    public function getTable() : string
    {
        return "Users";
    }

    public function getColumns() : array
    {
        return ["Name","Surname","BirthDate","Email","PasswordHash"];
    }
}