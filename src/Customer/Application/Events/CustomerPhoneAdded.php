<?php
declare(strict_types=1);

namespace App\Customer\Application\Events;

use App\Customer\Contracts\DomainEvent;
use App\Customer\Domain\Model\ValueObjects\CustomerId;
use App\Customer\Domain\Model\ValueObjects\Phone;

class CustomerPhoneAdded implements DomainEvent
{
    private CustomerId $customerId;
    private Phone $phone;

    public function __construct(CustomerId $customerId, Phone $phone)
    {
        $this->customerId = $customerId;
        $this->phone = $phone;
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
