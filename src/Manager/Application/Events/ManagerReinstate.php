<?php
declare(strict_types=1);

namespace App\Manager\Application\Events;

use App\Manager\Contracts\DomainEvent;
use App\Manager\Domain\Model\ValueObjects\ManagerId;
use DateTimeImmutable;

class ManagerReinstate implements DomainEvent
{
    private ManagerId $managerId;
    private \DateTimeImmutable $date;

    public function __construct(ManagerId $managerId, \DateTimeImmutable $date)
    {
        $this->managerId = $managerId;
        $this->date = $date;
    }

    public function getManagerId(): ManagerId
    {
        return $this->managerId;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
