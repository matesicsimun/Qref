<?php

namespace src\Service;

use DateTime;
use src\Interfaces\IUserRepository;
use src\Interfaces\IUserService;
use src\Model\User;

class UserService implements IUserService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function saveUser(array $userData): int
    {
        $user = $this->createUser($userData);
        return $this->userRepository->saveUser($user);
    }

    /**
     * Creates and returns a new User object
     * with attributes according to the data
     * provided as parameter.
     * @param array $userData
     * @return User
     */
    private function createUser(array $userData): ?User
    {
        if ($this->validateRegistrationData($userData)) {
            $user = new User();
            $user->__set("Name", $userData['name']);
            $user->__set("Surname", $userData['surname']);
            $user->__set("Email", $userData['email']);
            $user->__set("BirthDate", $userData['birthday']);
            $user->__set("PasswordHash", password_hash($userData['password'], PASSWORD_DEFAULT));
            $user->__set("Username", $userData['username']);

            return $user;
        }

        return null;
    }

    /**
     * Validates user registration data
     * Returns a boolean value TRUE if
     * the data is valid, and FALSE
     * if the data is not valid.
     * @param array $userData The user data stored in array.
     * @return bool The result of validation.
     */
    private function validateRegistrationData(array $userData){
        $valid = true;

        // Validate name
        $namePattern = "/^[A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+([\ A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+)*/u";
        $valid = $valid && preg_match($namePattern, $userData['name']);

        // Validate surname
        $valid = $valid && preg_match($namePattern, $userData['surname']);

        // Validate date of birth
        $valid = $valid && $this->validateDate($userData['birthday']);

        // Validate password
        $passwordPattern = "/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/";
        $valid = $valid && preg_match($passwordPattern, $userData['password']);
        $valid = $valid && preg_match($passwordPattern, $userData['password2']);

        // Validate email
        $valid = $valid && filter_var($userData['email'], FILTER_VALIDATE_EMAIL);

        return $valid;
    }

    /**
     * Makes sure the input is safe.
     * Returns safe input
     * @param string $data Possibly unsafe data.
     * @return string Safe data.
     */
    private function sanitizeData(string $data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    /**
     * Validates a date.
     * @param $date string Possibly invalid date.
     * @param string $format Format in which date is presented.
     * @return bool True if date valid, false otherwise.
     */
    private function validateDate(string $date, string $format = 'Y-m-d'): bool{
        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }

    /**
     * Checks if the user provided the right password.
     * @param string $password
     * @param string $password
     * @return bool
     */
    public function checkPasswordForUser(string $username, string $password): bool
    {
        $storedPassword = $this->loadUserByUsername($username)->__get("PasswordHash");
        return password_verify($password, $storedPassword);
    }

    public function setUserAttributes(User $user): User
    {
        $user->setId($user->getPrimaryKey());
        $user->setBirthDate($user->__get("BirthDate"));
        $user->setEmail($user->__get("Email"));
        $user->setName($user->__get("Name"));
        $user->setSurname($user->__get("Surname"));
        $user->setPasswordHash($user->__get("PasswordHash"));
        $user->setUserName($user->__get("Username"));
        return $user;
    }

    public function loadUserByUsername(string $username): ?User
    {
        $userNoAttributes = $this->userRepository->GetUserByUsername($username);
        return $this->setUserAttributes($userNoAttributes);
    }


    public function loadUserById(int $id): ?User
    {
        $userNoAttributes = $this->userRepository->getUser($id);
        return $this->setUserAttributes($userNoAttributes);
    }

    private function validatePassword(string $password): bool{
        $passwordPattern = "/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/";
        return preg_match($passwordPattern, $password);
    }

    public function updateUserPassword(string $username, string $passwordNew): int
    {
        if ($this->validatePassword($passwordNew)){

            $user = $this->userRepository->GetUserByUsername($username);
            $newPasswordHash = password_hash($passwordNew, PASSWORD_DEFAULT);
            $user->__set("PasswordHash", $newPasswordHash);
            return $this->userRepository->updateUser($user);
        }
        return -3;
    }
}