<?php
declare(strict_types=1);

namespace App\Customer\Contracts;

use App\Customer\Domain\Model\ValueObjects\CustomerId;

interface DomainEvent
{
    public function getCustomerId(): CustomerId;
}