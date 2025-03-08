<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

use App\Domain\User\Exception\InvalidEmailException;

final class Email
{
    private string $email;

    private function __construct(string $email)
    {
        $this->ensureIsValidEmail($email);
        $this->email = $email;
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function value(): string
    {
        return $this->email;
    }

    public function equals(Email $other): bool
    {
        return $this->email === $other->email;
    }

    private function ensureIsValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($email);
        }
    }

    public function __toString(): string
    {
        return $this->email;
    }
}