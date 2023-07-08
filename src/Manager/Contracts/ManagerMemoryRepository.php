<?php
declare(strict_types=1);

namespace App\Manager\Contracts;

use App\Manager\Domain\Model\Entities\Manager;
use App\Manager\Domain\Model\ValueObjects\ManagerId;

interface ManagerMemoryRepository
{
    public function byId(ManagerId $managerId): Manager;

    public function add(Manager $manager): void;

    public function save(Manager $manager): void;

    public function remove(Manager $manager): void;
}
