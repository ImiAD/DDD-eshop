<?php
declare(strict_types=1);

namespace App\Modules\Manager\Application\Events;

use App\Modules\Manager\Contracts\DomainEvent;
use App\Modules\Manager\Domain\Model\ValueObjects\ManagerId;

class ManagerArchived implements DomainEvent
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

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}
