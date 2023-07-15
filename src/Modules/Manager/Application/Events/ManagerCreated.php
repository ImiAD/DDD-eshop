<?php
declare(strict_types=1);

namespace App\Modules\Manager\Application\Events;

use App\Modules\Manager\Contracts\DomainEvent;
use App\Modules\Manager\Domain\Model\ValueObjects\ManagerId;

class ManagerCreated implements DomainEvent
{
    private ManagerId $managerId;

    public function __construct(ManagerId $managerId)
    {
        $this->managerId = $managerId;
    }

    public function getManagerId(): ManagerId
    {
        return $this->managerId;
    }
}
