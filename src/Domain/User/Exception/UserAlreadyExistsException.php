<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

final class UserAlreadyExistsException extends \DomainException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('User with email <%s> already exists', $email));
    }
}