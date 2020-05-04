<?php

namespace src\Service;

use DateTime;
use src\Interfaces\IUserService;
use src\Model\User;

class UserService implements IUserService
{

    /**
     * Creates and returns a new User object
     * with attributes according to the data
     * provided as parameter.
     * @param array $userData
     * @return User
     */
    public function createUser(array $userData): User
    {
        if ($this->validateRegistrationData($userData)) {
            $user = new User();
            $user->__set("Name", $userData['name']);
            $user->__set("Surname", $userData['surname']);
            $user->__set("Email", $userData['email']);
            $user->__set("BirthDate", $userData['birthday']);
            $user->__set("PasswordHash", password_hash($userData['password'], PASSWORD_DEFAULT));

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

}