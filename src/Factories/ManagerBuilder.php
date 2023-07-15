<?php
declare(strict_types=1);

namespace App\Factories;

use App\Modules\Manager\Collections\Phones;
use App\Modules\Manager\Domain\Model\Entities\Manager;
use App\Modules\Manager\Domain\Model\ValueObjects\Address;
use App\Modules\Manager\Domain\Model\ValueObjects\Date;
use App\Modules\Manager\Domain\Model\ValueObjects\ManagerId;
use App\Modules\Manager\Domain\Model\ValueObjects\Name;
use App\Modules\Manager\Domain\Model\ValueObjects\Phone;
use App\Modules\Manager\Domain\Model\ValueObjects\Role;

class ManagerBuilder
{
    private ManagerId $id;
    private Name $name;
    private Address $address;
    private array $phones;
    private Date $date;
    private bool $archived = false;
    private Role $role;

    public function __construct()
    {
        $this->id = ManagerId::next();
        $this->name= new Name('Karl', 'Richer', 'John');
        $this->address = new Address('Россия', 'Смоленска', 'Смоленск', 'Ленина', '1');
        $this->phones[] = new Phones([
            $phone1 = new Phone(7, '999', '090901'),
            $phone2 = new Phone(7, '111', '765434'),
        ]);
        $this->date = new Date(
            new \DateTimeImmutable('23-09-2023 21:21:21'),
            new \DateTimeImmutable('01-10-2023 23:21:00')
        );
        $this->role = new Role(Role::ADMIN, new \DateTimeImmutable('02-07-2023 10:23:01'));
    }

    public function withId(ManagerId $managerId): self
    {
        $clone = clone $this;
        $clone->id = $managerId;

        return $this;
    }

    public function withPhones(array $phones): self
    {
        $clone = clone $this;
        $clone->phones = $phones;

        return $this;
    }

    public function isActive(): self
    {
        $clone = clone $this;
        $clone->archived = true;

        return $this;
    }

    public function withRole(Role $role): self
    {
        $clone = clone $this;
        $clone->role = $role;

        return $this;
    }

    public function build(): Manager
    {
        $manager = new Manager(
            $this->id,
            $this->name,
            $this->address,
            $this->phones,
            $this->date,
            $this->role,
        );

        if ($this->archived) {
            $manager->archived(new \DateTimeImmutable());
        }

        return $manager;
    }
}
