<?php
declare(strict_types=1);

namespace App\Customer\Contracts;

abstract class AggregateRoot
{
    private array $recordedEvents = [];

    protected function recordEvent(DomainEvent $domainEvent): void
    {
        $this->recordedEvents[getClassName($domainEvent)] = $domainEvent;
    }

    public function releaseEvents(): array
    {
        $recordedEvents = $this->recordedEvents;
        $this->recordedEvents = [];

        return $recordedEvents;
    }
}