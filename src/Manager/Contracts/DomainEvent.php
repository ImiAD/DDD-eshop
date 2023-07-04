<?php
declare(strict_types=1);

namespace App\Manager\Contracts;

use App\Manager\Domain\Model\ValueObjects\ManagerId;

interface DomainEvent
{
    public function getManagerId(): ManagerId;
}
