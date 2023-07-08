<?php
declare(strict_types=1);

namespace App\Customer\Infrastructure\Memory;

use App\Customer\Domain\Model\Entities\Customer;
use App\Customer\Domain\Model\ValueObjects\Address;
use App\Customer\Domain\Model\ValueObjects\CustomerId;
use App\Customer\Domain\Model\ValueObjects\Date;
use App\Customer\Domain\Model\ValueObjects\Name;
use App\Customer\Domain\Model\ValueObjects\Phone;
use PHPUnit\Framework\TestCase;

class MemoryCustomerRepositoryTest extends TestCase
{
    public function testMemoryCustomerById(): void
    {
        $memoryCustomerRepository = new MemoryCustomerRepository();
        $customerId = CustomerId::next();

        $this->expectExceptionMessage('Покупатель не найден.');

        $memoryCustomerRepository->byId($customerId);
    }

    public function testIsEmpty(): void
    {
        $memoryCustomerRepository = new MemoryCustomerRepository();

        $this->assertEmpty($memoryCustomerRepository->all());
    }

    public function testAddAndRemoveCustomer(): void
    {
        $memoryCustomerRepository = new MemoryCustomerRepository();
        $customer = new Customer(
            $customerId = CustomerId::next(),
            $name = new Name('Ivan', 'Ivanov', 'Ivanovich'),
            $address = new Address(
                'Россия',
                'Смоленска обл.',
                'г.Смоленск',
                'ул.Ленина',
                '1'
            ),
            $phones = [
                $phone1 = new Phone(7, '921', '000001'),
                $phone2 = new Phone(7, '922', '000002'),
            ],
            $date = new Date(
                new \DateTimeImmutable('22-01-2023 14:12:43'),
                new \DateTimeImmutable('21-01-2023 15:12:43'),
            ),
        );

        $memoryCustomerRepository->add($customer);

        $this->assertEquals($customer, $memoryCustomerRepository->byId($customerId));
        $this->assertEquals([$customer->getId()->getId() => $customer], $memoryCustomerRepository->all());

        $memoryCustomerRepository->remove($customer);

        $this->assertEmpty($memoryCustomerRepository->all());
    }
}
