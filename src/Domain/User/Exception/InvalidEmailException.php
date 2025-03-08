<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

final class InvalidEmailException extends \DomainException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('The email <%s> is invalid', $email));
    }
}