<?php
declare(strict_types=1);

namespace App\Manager\Domain\Model\Entities;

use App\Modules\Manager\Application\Events\ManagerCreated;
use App\Modules\Manager\Domain\Model\Entities\Manager;
use App\Modules\Manager\Domain\Model\ValueObjects\Address;
use App\Modules\Manager\Domain\Model\ValueObjects\Date;
use App\Modules\Manager\Domain\Model\ValueObjects\ManagerId;
use App\Modules\Manager\Domain\Model\ValueObjects\Name;
use App\Modules\Manager\Domain\Model\ValueObjects\Phone;
use App\Modules\Manager\Domain\Model\ValueObjects\Role;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    public function testCanCreate(): void
    {
        $manager = new Manager(
            $id = ManagerId::next(),
            $name = new Name('Petrov', 'Petrenko', 'Petrenkovich'),
            $address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Сталина', '1'),
            $phones = [
                $phone1 = new Phone(7, '333', '444444'),
                $phone2 = new Phone(7, '444', '111000'),
            ],
            $date = new Date(
                new \DateTimeImmutable('02-07-2023 19:54:01'),
                new \DateTimeImmutable('03-07-2023 21:10:02'),
            ),
            $role = new Role('Admin', new \DateTimeImmutable('02-07-2023 10:23:01')),
        );

        $this->assertInstanceOf(Manager::class, $manager);
        $this->assertSame($id, $manager->getId());
        $this->assertSame($name, $manager->getName());
        $this->assertSame($address, $manager->getAddress());
        $this->assertSame($phones, $manager->getPhones());
        $this->assertSame('02-07-2023 19:54:01', $manager->getCreatedAt()->format('d-m-Y H:i:s'));
        $this->assertSame('03-07-2023 21:10:02', $manager->getUpdatedAt()->format('d-m-Y H:i:s'));
        $this->assertTrue($manager->isActive());
        $this->assertCount(1, $statuses = $manager->getStatuses());
        $this->assertTrue(end($statuses)->isActive());
        $this->assertNotEmpty($event = $manager->releaseEvents());
        $this->assertInstanceOf(ManagerCreated::class, end($event));
        $this->assertSame($role, $manager->getRole());
        $this->assertSame(Role::ADMIN, $manager->getRole()->getValue());
    }

    public function testWithoutPhone(): void
    {
        $this->expectExceptionMessage('У менеджер должен быть хотя бы один номер телефона.');

        $manager = new Manager(
            $id = ManagerId::next(),
            $name = new Name('Petrov', 'Petrenko', 'Petrenkovich'),
            $address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Сталина', '1'),
            $phones = [],
            $date = new Date(
                new \DateTimeImmutable('02-07-2023 19:54:01'),
                new \DateTimeImmutable('03-07-2023 21:10:02'),
            ),
            $role = new Role('Admin', new \DateTimeImmutable('02-07-2023 10:23:01')),
        );
    }

    public function testPhonesExists(): void
    {
        $manager = new Manager(
            $id = ManagerId::next(),
            $name = new Name('Petrov', 'Petrenko', 'Petrenkovich'),
            $address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Сталина', '1'),
            $phones = [
                $phone1 = new Phone(7, '333', '444444'),
                $phone2 = new Phone(7, '444', '111000'),
            ],
            $date = new Date(
                new \DateTimeImmutable('02-07-2023 19:54:01'),
                new \DateTimeImmutable('03-07-2023 21:10:02'),
            ),
            $role = new Role('Admin', new \DateTimeImmutable('02-07-2023 10:23:01')),
        );

        $this->expectExceptionMessage('Такой номер телефона уже существует.');

        $manager->addPhone($phone1);
    }

    public function testRepeatRoel(): void
    {
        $manager = new Manager(
            $id = ManagerId::next(),
            $name = new Name('Petrov', 'Petrenko', 'Petrenkovich'),
            $address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Сталина', '1'),
            $phones = [
                $phone1 = new Phone(7, '333', '444444'),
                $phone2 = new Phone(7, '444', '111000'),
            ],
            $date = new Date(
                new \DateTimeImmutable('02-07-2023 19:54:01'),
                new \DateTimeImmutable('03-07-2023 21:10:02'),
            ),
            $role = new Role('Admin', new \DateTimeImmutable('02-07-2023 10:23:01')),
        );

        $this->expectExceptionMessage('Менеджеру уже предоставлена данная роль.');

        $manager->changeRole($role);
    }
}
