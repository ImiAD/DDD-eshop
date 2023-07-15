<?php
declare(strict_types=1);

namespace App\Modules\Manager\Application\Events;

use App\Modules\Manager\Contracts\DomainEvent;
use App\Modules\Manager\Domain\Model\ValueObjects\Address;
use App\Modules\Manager\Domain\Model\ValueObjects\ManagerId;

class ManagerAddressChanged implements DomainEvent
{
    private ManagerId $managerId;
    private Address $address;

    public function __construct(ManagerId $managerId, Address $address)
    {
        $this->managerId = $managerId;
        $this->address = $address;
    }

    public function getManagerId(): ManagerId
    {
        return $this->managerId;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}
