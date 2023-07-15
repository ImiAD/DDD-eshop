<?php
declare(strict_types=1);

namespace App\Modules\Manager\Application\Events;

use App\Modules\Manager\Contracts\DomainEvent;
use App\Modules\Manager\Domain\Model\ValueObjects\ManagerId;
use App\Modules\Manager\Domain\Model\ValueObjects\Name;

class ManagerRename implements DomainEvent
{
    private ManagerId $managerId;
    private Name $name;

    public function __construct(ManagerId $managerId, Name $name)
    {
        $this->managerId = $managerId;
        $this->name = $name;
    }

    public function getManagerId(): ManagerId
    {
        return $this->managerId;
    }

    public function getName(): Name
    {
        return $this->name;
    }
}
