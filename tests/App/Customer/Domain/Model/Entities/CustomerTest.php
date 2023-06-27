<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\Entities;

use App\Customer\Domain\Model\Collections\Phones;
use App\Customer\Domain\Model\ValueObjects\Address;
use App\Customer\Domain\Model\ValueObjects\CustomerId;
use App\Customer\Domain\Model\ValueObjects\Date;
use App\Customer\Domain\Model\ValueObjects\Name;
use App\Customer\Domain\Model\ValueObjects\Phone;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testCanCreate(): void
    {
        $customer = new Customer(
            $id = CustomerId::next(),
            $name = new Name('Ivan', 'Ivanov', 'Ivanovich'),
            $phones = new Phones([
                $phone1 = new Phone(7, '920', '0000001'),
                $phone2 = new Phone(7, '920', '0000002'),
            ]),
            $address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Ленина', '12'),
            $date = new Date(
                new \DateTimeImmutable(date('d.m.Y H:i:s')),
                new \DateTimeImmutable(date('d.m.Y H:i:s')),
            ),
        );

        $this->assertSame($id, $customer->getId());
        $this->assertSame($name, $customer->getName());
        $this->assertSame($phones, $customer->getPhones());
        $this->assertSame($address, $customer->getAddress());
        $this->assertSame($date, $customer->getCreatedAt());
        $this->assertSame($date, $customer->getUpdatedAt());
    }
}
