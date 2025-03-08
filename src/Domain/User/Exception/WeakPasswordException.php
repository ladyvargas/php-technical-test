<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

final class WeakPasswordException extends \DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}