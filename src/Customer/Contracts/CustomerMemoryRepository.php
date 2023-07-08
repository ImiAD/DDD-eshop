<?php
declare(strict_types=1);

namespace App\Customer\Contracts;

use App\Customer\Domain\Model\Entities\Customer;
use App\Customer\Domain\Model\ValueObjects\CustomerId;

interface CustomerMemoryRepository
{
    public function byId(CustomerId $customerId): Customer;

    public function all(): array;

    public function add(Customer $customer): void;

    public function save(Customer $customer): void;

    public function remove(Customer $customer): void;
}
