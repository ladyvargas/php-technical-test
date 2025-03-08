<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

use App\Domain\User\Exception\WeakPasswordException;

final class Password
{
    private string $hashedPassword;

    private function __construct(string $hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }

    public static function fromPlainPassword(string $plainPassword): self
    {
        self::ensureIsStrongPassword($plainPassword);
        return new self(self::hash($plainPassword));
    }

    public static function fromHash(string $hash): self
    {
        return new self($hash);
    }

    public function value(): string
    {
        return $this->hashedPassword;
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedPassword);
    }

    private static function hash(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    private static function ensureIsStrongPassword(string $password): void
    {
        if (strlen($password) < 8) {
            throw new WeakPasswordException('Password must be at least 8 characters long');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new WeakPasswordException('Password must contain at least one uppercase letter');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new WeakPasswordException('Password must contain at least one number');
        }

        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            throw new WeakPasswordException('Password must contain at least one special character');
        }
    }
}