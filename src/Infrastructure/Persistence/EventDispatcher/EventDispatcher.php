<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\EventDispatcher;

class EventDispatcher
{
    private array $listeners = [];

    public function addListener(string $eventClassName, callable $listener): void
    {
        $this->listeners[$eventClassName][] = $listener;
    }

    public function dispatch(object $event): void
    {
        $eventClassName = get_class($event);
        
        if (!isset($this->listeners[$eventClassName])) {
            return;
        }
        
        foreach ($this->listeners[$eventClassName] as $listener) {
            $listener($event);
        }
    }
}