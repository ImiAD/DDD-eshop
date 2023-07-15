<?php
declare(strict_types=1);

namespace App\Modules\Manager\Contracts;

use App\Modules\Manager\Domain\Model\Entities\Manager;
use App\Modules\Manager\Domain\Model\ValueObjects\ManagerId;

interface ManagerMemoryRepository
{
    public function byId(ManagerId $managerId): Manager;

    public function add(Manager $manager): void;

    public function save(Manager $manager): void;

    public function remove(Manager $manager): void;
}
