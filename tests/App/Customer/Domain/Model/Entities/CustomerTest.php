<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\Entities;

use App\Modules\Customer\Application\Events\CustomerCreated;
use App\Modules\Customer\Domain\Model\Entities\Customer;
use App\Modules\Customer\Domain\Model\ValueObjects\Address;
use App\Modules\Customer\Domain\Model\ValueObjects\CustomerId;
use App\Modules\Customer\Domain\Model\ValueObjects\Date;
use App\Modules\Customer\Domain\Model\ValueObjects\Name;
use App\Modules\Customer\Domain\Model\ValueObjects\Phone;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testSuccess(): void
    {
        $customer = new Customer(
            $id = CustomerId::next(),
            $name = new Name('Pupkin', 'Sidor', 'Pupkovich'),
            $address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Ленина', '11'),
            $phones = [
                new Phone(7, '921', '000001'),
                new Phone(7, '922', '000002'),
            ],
            $date = new Date(
                new \DateTimeImmutable('30-06-2023 22:25:00'),
                new \DateTimeImmutable('30-06-2023 22:25:00'),
            ),
        );

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertSame($id, $customer->getId());
        $this->assertSame($name, $customer->getName());
        $this->assertSame($address, $customer->getAddress());
        $this->assertSame($phones, $customer->getPhones());
        $this->assertSame('30-06-2023 22:25:00', $customer->getCreateAt()->format('d-m-Y H:i:s'));
        $this->assertSame('30-06-2023 22:25:00', $customer->getUpdatedAt()->format('d-m-Y H:i:s'));
        $this->assertTrue($customer->isActive());
        $this->assertCount(1, $statuses = $customer->getStatuses());
        $this->assertTrue(end($statuses)->isActive());
        $this->assertNotEmpty($event = $customer->releaseEvents());
        $this->assertInstanceOf(CustomerCreated::class, end($event));
    }

    public function testWithoutPhone(): void
    {
        $this->expectExceptionMessage('Покупатель должен иметь хотя бы один номер.');

        $customer = new Customer(
            $id = CustomerId::next(),
            $name = new Name('Pupkin', 'Sidor', 'Pupkovich'),
            $address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Ленина', '11'),
            $phones = [],
            $date = new Date(
                new \DateTimeImmutable('30-06-2023 22:25:00'),
                new \DateTimeImmutable('30-06-2023 22:25:00'),
            ),
        );
    }

    public function testPhoneExists(): void
    {
        $customer = new Customer(
            $id = CustomerId::next(),
            $name = new Name('Pupkin', 'Sidor', 'Pupkovich'),
            $address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Ленина', '11'),
            $phones = [
                new Phone(7, '921', '000001'),
                new Phone(7, '922', '000002'),
            ],
            $date = new Date(
                new \DateTimeImmutable('30-06-2023 22:25:00'),
                new \DateTimeImmutable('30-06-2023 22:25:00'),
            ),
        );

        $this->expectExceptionMessage('Такой номер телефона уже существует.');

        $customer->addPhone(new Phone(7, '922', '000002'));
    }
}
