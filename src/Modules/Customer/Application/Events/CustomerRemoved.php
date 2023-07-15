<?php
declare(strict_types=1);

namespace App\Modules\Customer\Application\Events;

use App\Modules\Customer\Contracts\DomainEvent;
use App\Modules\Customer\Domain\Model\ValueObjects\CustomerId;

class CustomerRemoved implements DomainEvent
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
