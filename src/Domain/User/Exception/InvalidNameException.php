<?php

namespace App\Domain\User\Exception;

use InvalidArgumentException as BaseInvalidArgumentException;

class InvalidNameException extends BaseInvalidArgumentException
{
    const EMPTY_NAME = 1;
    const TOO_SHORT_NAME = 2;
    const TOO_LONG_NAME = 3;

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        if (!$message) {
            switch ($code) {
                case self::EMPTY_NAME:
                    $message = "The name cannot be empty.";
                    break;
                case self::TOO_SHORT_NAME:
                    $message = "The name must be at least 3 characters long.";
                    break;
                case self::TOO_LONG_NAME:
                    $message = "The name is too long.";
                    break;
                default:
                    $message = "Invalid name provided.";
            }
        }

        parent::__construct($message, $code, $previous);
    }
}

