<?php
declare(strict_types=1);

namespace App\Manager\Infrastructure;

use App\Manager\Domain\Model\Entities\Manager;
use App\Manager\Domain\Model\ValueObjects\Address;
use App\Manager\Domain\Model\ValueObjects\Date;
use App\Manager\Domain\Model\ValueObjects\ManagerId;
use App\Manager\Domain\Model\ValueObjects\Name;
use App\Manager\Domain\Model\ValueObjects\Phone;
use App\Manager\Domain\Model\ValueObjects\Role;
use App\Manager\Infrastructure\Memory\MemoryManagerRepository;
use PHPUnit\Framework\TestCase;

class ManagerMemoryRepositoryTest extends TestCase
{
    public function testNoFoundManager(): void
    {
        $managerMemoryRepository = new MemoryManagerRepository();
        $manager = new Manager(
            $managerId = ManagerId::next(),
            $name = new Name('Petrov', 'Petrenko', 'Petrenkovich'),
            $address = new Address(
                'Россия',
                'Смоленская обл.',
                'г.Смоленск',
                'ул.Сталина',
                '1'
            ),
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

        $this->expectExceptionMessage('Менеджер не найден.');

        $managerMemoryRepository->byId($managerId);
    }

    public function testAddAndRemoveManager(): void
    {
        $managerMemoryRepository = new MemoryManagerRepository();
        $manager = new Manager(
            $managerId = ManagerId::next(),
            $name = new Name('Petrov', 'Petrenko', 'Petrenkovich'),
            $address = new Address(
                'Россия',
                'Смоленская обл.',
                'г.Смоленск',
                'ул.Сталина',
                '1'
            ),
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

        $managerMemoryRepository->add($manager);

        $this->assertEquals($manager, $managerMemoryRepository->byId($managerId));
        $this->assertEquals([$manager->getId()->getId() => $manager], $managerMemoryRepository->all());

        $managerMemoryRepository->remove($manager);

        $this->assertEmpty($managerMemoryRepository->all());
    }
}
