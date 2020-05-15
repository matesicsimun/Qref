<?php


namespace src\Model\AbstractClasses;


class ErrorMessages
{
    public static function translateErrorCode(int $errorCode): string{
        if ($errorCode === ErrorCodes::USER_DATA_INVALID) return "User registration data is invalid.";
    }
}