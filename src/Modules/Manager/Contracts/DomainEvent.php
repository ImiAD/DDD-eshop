<?php
declare(strict_types=1);

namespace App\Modules\Manager\Contracts;

use App\Modules\Manager\Domain\Model\ValueObjects\ManagerId;

interface DomainEvent
{
    public function getManagerId(): ManagerId;
}
