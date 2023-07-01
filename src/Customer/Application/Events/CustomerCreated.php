<?php
declare(strict_types=1);

namespace App\Customer\Application\Events;

use App\Customer\Contracts\DomainEvent;
use App\Customer\Domain\Model\ValueObjects\CustomerId;

class CustomerCreated implements DomainEvent
{
    private CustomerId $customerId;

    public function __construct(CustomerId $customerId)
    {
        $this->customerId = $customerId;
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }
}
