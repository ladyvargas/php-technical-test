<?php

declare(strict_types=1);

namespace App\Domain\User\ValueObject;

final class Name
{
    private string $name;
    private const MIN_LENGTH = 3;

    private function __construct(string $name)
    {
        $this->ensureIsValidName($name);
        $this->name = $name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function value(): string
    {
        return $this->name;
    }

    private function ensureIsValidName(string $name): void
    {
        if (strlen($name) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Name must be at least %d characters long', self::MIN_LENGTH)
            );
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            throw new \InvalidArgumentException('Name contains invalid characters');
        }
    }

    public function __toString(): string
    {
        return $this->name;
    }
}