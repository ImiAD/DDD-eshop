<?php
declare(strict_types=1);

namespace App\Customer\Application\Events;

use App\Customer\Contracts\DomainEvent;
use App\Customer\Domain\Model\ValueObjects\Address;
use App\Customer\Domain\Model\ValueObjects\CustomerId;

class CustomerAddressChanged implements DomainEvent
{
    private CustomerId $customerId;
    private Address $address;

    public function __construct(CustomerId $customerId, Address $address)
    {
        $this->customerId = $customerId;
        $this->address = $address;
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}
