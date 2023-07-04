<?php
declare(strict_types=1);

namespace App\Manager\Application\Events;

use App\Manager\Contracts\DomainEvent;
use App\Manager\Domain\Model\ValueObjects\Address;
use App\Manager\Domain\Model\ValueObjects\ManagerId;

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
