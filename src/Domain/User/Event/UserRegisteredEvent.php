<?php

declare(strict_types=1);

namespace App\Domain\User\Event;

use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\UserId;

final class UserRegisteredEvent
{
    private UserId $userId;
    private Email $email;
    private \DateTimeImmutable $occurredOn;

    public function __construct(UserId $userId, Email $email)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}