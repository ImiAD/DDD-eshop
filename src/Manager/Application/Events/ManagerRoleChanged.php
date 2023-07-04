<?php
declare(strict_types=1);

namespace App\Manager\Application\Events;

use App\Manager\Contracts\DomainEvent;
use App\Manager\Domain\Model\ValueObjects\ManagerId;
use App\Manager\Domain\Model\ValueObjects\Role;

class ManagerRoleChanged implements DomainEvent
{
    private ManagerId $managerId;
    private Role $role;

    public function __construct(ManagerId $managerId, Role $role)
    {
        $this->managerId = $managerId;
        $this->role = $role;
    }

    public function getManagerId(): ManagerId
    {
        return $this->managerId;
    }

    public function getRole(): Role
    {
        return $this->role;
    }
}
