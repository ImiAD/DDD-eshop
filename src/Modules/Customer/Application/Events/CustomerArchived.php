<?php
declare(strict_types=1);

namespace App\Modules\Customer\Application\Events;

use App\Modules\Customer\Contracts\DomainEvent;
use App\Modules\Customer\Domain\Model\ValueObjects\CustomerId;

class CustomerArchived implements DomainEvent
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
