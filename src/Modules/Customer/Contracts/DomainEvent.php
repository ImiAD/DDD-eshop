<?php
declare(strict_types=1);

namespace App\Modules\Customer\Contracts;

use App\Modules\Customer\Domain\Model\ValueObjects\CustomerId;

interface DomainEvent
{
    public function getCustomerId(): CustomerId;
}