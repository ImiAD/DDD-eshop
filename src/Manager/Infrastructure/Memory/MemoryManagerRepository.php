<?php
declare(strict_types=1);

namespace App\Manager\Infrastructure\Memory;

use App\Manager\Contracts\ManagerMemoryRepository;
use App\Manager\Domain\Model\Entities\Manager;
use App\Manager\Domain\Model\ValueObjects\ManagerId;

class MemoryManagerRepository implements ManagerMemoryRepository
{
    private array $items = [];

    public function byId(ManagerId $managerId): Manager
    {
        if (!isset($this->items[$managerId->getId()])) {
            throw new \DomainException('Менеджер не найден.');
        }

        return clone $this->items[$managerId->getId()];
    }

    public function all(): array
    {
        return $this->items;
    }

    public function add(Manager $manager): void
    {
        $this->items[$manager->getId()->getId()] = $manager;
    }

    public function save(Manager $manager): void
    {
        $this->items[$manager->getId()->getId()] = $manager;
    }

    public function remove(Manager $manager): void
    {
        unset($this->items[$manager->getId()->getId()]);
    }
}
