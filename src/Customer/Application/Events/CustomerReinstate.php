<?php
declare(strict_types=1);

namespace App\Customer\Application\Events;

use App\Customer\Contracts\DomainEvent;
use App\Customer\Domain\Model\ValueObjects\CustomerId;

class CustomerReinstate implements DomainEvent
{
    private CustomerId $customerId;
    private \DateTimeImmutable $date;

    public function __construct(CustomerId $customerId, \DateTimeImmutable $date)
    {
        $this->customerId = $customerId;
        $this->date = $date;
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}
