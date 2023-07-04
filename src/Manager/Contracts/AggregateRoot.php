<?php
declare(strict_types=1);

namespace App\Manager\Contracts;

abstract class AggregateRoot
{
    private array $recordEvents = [];

    protected function recordEvents(DomainEvent $domainEvent): void
    {
        $this->recordEvents[getClassName($domainEvent)] = $domainEvent;
    }

    public function releaseEvents(): array
    {
        $recordEvents = $this->recordEvents;
        $this->recordEvents = [];

        return $recordEvents;
    }
}
