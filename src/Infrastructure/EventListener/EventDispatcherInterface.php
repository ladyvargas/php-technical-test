<?php

namespace App\Infrastructure\EventListener;

/**
 * Interface for event dispatchers in the application
 */
interface EventDispatcherInterface
{
    /**
     * Dispatches an event to all registered listeners
     *
     * @param object $event The event to dispatch
     * @return void
     */
    public function dispatch(object $event): void;
    
    /**
     * Adds a listener for a specific event
     *
     * @param string $eventClass The event class name
     * @param callable $listener The listener callback
     * @return void
     */
    public function addListener(string $eventClass, callable $listener): void;
}