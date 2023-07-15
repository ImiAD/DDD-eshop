<?php
declare(strict_types=1);

namespace App\Modules\Manager\Application\Events;

use App\Modules\Manager\Contracts\DomainEvent;
use App\Modules\Manager\Domain\Model\ValueObjects\ManagerId;
use App\Modules\Manager\Domain\Model\ValueObjects\Phone;

class ManagerPhoneAdded implements DomainEvent
{
    private ManagerId $managerId;
    private Phone $phone;

    public function __construct(ManagerId $managerId, Phone $phone)
    {
        $this->managerId = $managerId;
        $this->phone = $phone;
    }

    public function getManagerId(): ManagerId
    {
        return $this->managerId;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
