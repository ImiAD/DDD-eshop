<?php
declare(strict_types=1);

namespace App\Manager\Domain\Model\Entities;

use App\Manager\Application\Events\ManagerAddressChanged;
use App\Manager\Application\Events\ManagerArchived;
use App\Manager\Application\Events\ManagerCreated;
use App\Manager\Application\Events\ManagerPhoneAdded;
use App\Manager\Application\Events\ManagerReinstate;
use App\Manager\Application\Events\ManagerRemoved;
use App\Manager\Application\Events\ManagerRename;
use App\Manager\Application\Events\ManagerRoleChanged;
use App\Manager\Collections\Phones;
use App\Manager\Contracts\AggregateRoot;
use App\Manager\Domain\Model\ValueObjects\Address;
use App\Manager\Domain\Model\ValueObjects\Date;
use App\Manager\Domain\Model\ValueObjects\ManagerId;
use App\Manager\Domain\Model\ValueObjects\Name;
use App\Manager\Domain\Model\ValueObjects\Phone;
use App\Manager\Domain\Model\ValueObjects\Role;
use App\Manager\Domain\Model\ValueObjects\Status;

class Manager extends AggregateRoot
{
    private ManagerId $id;
    private Name $name;
    private Address $address;
    private Phones $phones;
    private Date $date;
    private array $statuses = [];
    private Role $role;

    public function __construct(
        ManagerId $id,
        Name $name,
        Address $address,
        array $phones,
        Date $date,
        Role $role,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->phones = new Phones($phones);
        $this->date = $date;
        $this->addStatus(Status::ACTIVE, new \DateTimeImmutable());
        $this->recordEvents(new ManagerCreated($this->id));
        $this->role = $role;
    }

    public function changeRole(Role $role): void
    {
        if ($this->role->isEqualsTo($role)) {
            throw new \DomainException('Менеджеру уже предоставлена данная роль.');
        }

        $this->role = $role;
        $this->recordEvents(new ManagerRoleChanged($this->id, $role));
    }

    public function remove(): void
    {
        if (!$this->isArchived()) {
            throw new \DomainException('Нельзя удалить активного пользователя.');
        }

        $this->recordEvents(new ManagerRemoved($this->id));
    }

    public function rename(Name $name): void
    {
        $this->name = $name;
        $this->recordEvents(new ManagerRename($this->id, $name));
    }

    public function changeAddress(Address $address): void
    {
        $this->address = $address;
        $this->recordEvents(New ManagerAddressChanged($this->id, $address));
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones->add($phone);
        $this->recordEvents(new ManagerPhoneAdded($this->id, $phone));
    }

    public function archived(\DateTimeImmutable $date): void
    {
        if ($this->isArchived()) {
            throw new \DomainException('Менеджер уже заблокирован.');
        }

        $this->addStatus(Status::ARCHIVED, $date);
        $this->recordEvents(new ManagerArchived($this->id, $date));
    }

    public function reinstate(\DateTimeImmutable $date): void
    {
        if (!$this->isArchived()) {
            throw new \DomainException('Покупатель не заблокирован.');
        }

        $this->addStatus(Status::ACTIVE, $date);
        $this->recordEvents(new ManagerReinstate($this->id, $date));
    }

    public function addStatus(string $value, \DateTimeImmutable $date): void
    {
        $this->statuses[] = new Status($value, $date);
    }

    public function isActive(): bool
    {
        return $this->getCurrentStatus()->isActive();
    }

    public function isArchived(): bool
    {
        return $this->getCurrentStatus()->isArchived();
    }

    private function getCurrentStatus(): Status
    {
        return end($this->statuses);
    }


    public function getId(): ManagerId
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getPhones(): array
    {
        return $this->phones->getAll();
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->date->getCreatedAt();
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->date->getUpdatedAt();
    }

    public function getStatuses(): array
    {
        return $this->statuses;
    }

    public function getRole(): Role
    {
        return $this->role;
    }
}
