<?php

declare(strict_types=1);

namespace App\Application\ServiceBus;

class EventBus
{
    /** @var array */
    private $listeners = [];

    public function registerListener($listener)
    {
        $this->listeners[] = $listener;
    }

    public function dispatch(array $event)
    {
        foreach ($this->listeners as $listener) {
            $listener->handle($event);
        }
    }
}

