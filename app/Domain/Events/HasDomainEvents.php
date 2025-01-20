<?php

declare(strict_types=1);

namespace App\Domain\Events;

trait HasDomainEvents
{
    private array $domainEvents = [];

    protected function addDomainEvent(object $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }

    public function clearDomainEvents(): void
    {
        $this->domainEvents = [];
    }
}
