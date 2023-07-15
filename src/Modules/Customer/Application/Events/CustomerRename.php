<?php
declare(strict_types=1);

namespace App\Modules\Customer\Application\Events;

use App\Modules\Customer\Contracts\DomainEvent;
use App\Modules\Customer\Domain\Model\ValueObjects\CustomerId;
use App\Modules\Customer\Domain\Model\ValueObjects\Name;

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
