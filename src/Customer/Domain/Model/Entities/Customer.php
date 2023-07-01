<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\Entities;

use App\Customer\Application\Events\CustomerAddressChanged;
use App\Customer\Application\Events\CustomerArchived;
use App\Customer\Application\Events\CustomerCreated;
use App\Customer\Application\Events\CustomerPhoneAdded;
use App\Customer\Application\Events\CustomerReinstate;
use App\Customer\Application\Events\CustomerRemoved;
use App\Customer\Application\Events\CustomerRename;
use App\Customer\Collections\Phones;
use App\Customer\Contracts\AggregateRoot;
use App\Customer\Domain\Model\ValueObjects\Address;
use App\Customer\Domain\Model\ValueObjects\CustomerId;
use App\Customer\Domain\Model\ValueObjects\Date;
use App\Customer\Domain\Model\ValueObjects\Name;
use App\Customer\Domain\Model\ValueObjects\Phone;
use App\Customer\Domain\Model\ValueObjects\Status;

class Customer extends AggregateRoot
{
    private CustomerId $id;
    private Name $name;
    private Phones $phones;
    private Address $address;
    private Date $date;
    private array $statuses = [];

    public function __construct(
        CustomerId $id,
        Name       $name,
        Address    $address,
        array      $phones,
        Date       $date,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->phones = new Phones($phones);
        $this->address = $address;
        $this->date = $date;
        $this->addStatus(Status::ACTIVE, new \DateTimeImmutable());
        $this->recordEvent(new CustomerCreated($this->id));
    }

    public function remove(): void
    {
        if (!$this->isArchived()) {
            throw new \DomainException('Нельзя удалить активного пользователя.');
        }

        $this->recordEvent(new CustomerRemoved($this->id));
    }

    public function rename(Name $name): void
    {
        $this->name = $name;
        $this->recordEvent(new CustomerRename($this->id, $name));
    }

    public function changeAddress(Address $address): void
    {
        $this->address = $address;
        $this->recordEvent(new CustomerAddressChanged($this->id, $address));
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones->add($phone);
        $this->recordEvent(new CustomerPhoneAdded($this->id, $phone));
    }

    public function archive(\DateTimeImmutable $date): void
    {
        if ($this->isArchived()) {
            throw new \DomainException('Покупатель уже в архиве.');
        }

        $this->addStatus(Status::ARCHIVED, $date);
        $this->recordEvent(new CustomerArchived($this->id, $date));
    }

    public function reinstate(\DateTimeImmutable $date): void
    {
        if (!$this->isArchived()) {
            throw new \DomainException('Покупатель не в архиве.');
        }

        $this->addStatus(Status::ACTIVE, $date);
        $this->recordEvent(new CustomerReinstate($this->id, $date));
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

    public function getId(): CustomerId
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

    public function getStatuses(): array
    {
        return $this->statuses;
    }

    public function getCreateAt(): \DateTimeImmutable
    {
        return $this->date->getCreatedAt();
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->date->getUpdatedAt();
    }
}
