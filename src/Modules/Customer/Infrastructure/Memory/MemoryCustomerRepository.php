<?php
declare(strict_types=1);

namespace App\Modules\Customer\Infrastructure\Memory;

use App\Modules\Customer\Contracts\CustomerMemoryRepository;
use App\Modules\Customer\Domain\Model\Entities\Customer;
use App\Modules\Customer\Domain\Model\ValueObjects\CustomerId;

class MemoryCustomerRepository implements CustomerMemoryRepository
{
    private array $items = [];

    public function byId(CustomerId $customerId): Customer
    {
        if (!isset($this->items[$customerId->getId()])) {
            throw new \DomainException('Покупатель не найден.');
        }

        return clone $this->items[$customerId->getId()];
    }

    public function all(): array
    {
        return $this->items;
    }

    public function add(Customer $customer): void
    {
        $this->items[$customer->getId()->getId()] = $customer;
    }

    public function save(Customer $customer): void
    {
        $this->items[$customer->getId()->getId()] = $customer;
    }

    public function remove(Customer $customer): void
    {
        unset($this->items[$customer->getId()->getId()]);
    }
}
