<?php


namespace src\Model\AbstractClasses;


class Messages
{
    public static function translateMessageCode(int $msgCode): string{
        if ($msgCode === MessageCodes::USER_NOT_FOUND) return "User not found.";
        else if ($msgCode === MessageCodes::USERNAME_PASSWORD_INCORRECT) return "Incorrect username-password combination.";
        else if ($msgCode === MessageCodes::LOGIN_SUCCESSFUL) return "Welcome back!";
        else if ($msgCode === MessageCodes::LOGOUT_SUCCESSFUL) return "Goodbye!";
        else if ($msgCode === MessageCodes::ERROR_UNKNOWN) return "Unknown error occurred.";
        else if ($msgCode === MessageCodes::USERNAME_TAKEN) return "Username already taken.";
        else if ($msgCode === MessageCodes::REGISTER_SUCCESSFUL) return "Registration complete!";
        else if ($msgCode === MessageCodes::USER_DATA_INVALID) return "Registration data invalid.";
        else if ($msgCode === MessageCodes::REGISTER_UNSUCCESSFUL) return "Registration failed.";
        else{
            return "";
        }
    }
}