<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\Aggregates;

use App\Customer\Contracts\DomainEvent;

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