<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Domain\User\Event\UserRegisteredEvent;

final class UserRegisteredEventListener
{
    public function __invoke(UserRegisteredEvent $event): void
    {
        // Here we would implement the welcome email sending
        // This is just a simulation
        
        $userId = $event->userId()->value();
        $email = $event->email()->value();
        
        // Log that we're sending a welcome email
        error_log(sprintf(
            "Sending welcome email to user %s with email %s at %s",
            $userId,
            $email,
            $event->occurredOn()->format('Y-m-d H:i:s')
        ));
        
        // In a real implementation, we would call an email service here
    }
}