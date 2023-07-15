<?php
declare(strict_types=1);

namespace App\Modules\Customer\Contracts;

use App\Modules\Customer\Domain\Model\Entities\Customer;
use App\Modules\Customer\Domain\Model\ValueObjects\CustomerId;

interface CustomerRepository
{
    public function byId(CustomerId $customerId): array;

    public function all(): array;

    public function create(Customer $customer): bool;

    public function update(string $customerId, Customer $customer): bool;

    public function remove(Customer $customer): void;
}
