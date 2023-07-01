<?php
declare(strict_types=1);

namespace App\Customer\Application\Events;

use App\Customer\Contracts\DomainEvent;
use App\Customer\Domain\Model\ValueObjects\CustomerId;
use App\Customer\Domain\Model\ValueObjects\Name;

class CustomerRename implements DomainEvent
{
    private CustomerId $customerId;
    private Name $name;

    public function __construct(CustomerId $customerId, Name $name)
    {
        $this->customerId = $customerId;
        $this->name = $name;
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    public function getName(): Name
    {
        return $this->name;
    }
}
