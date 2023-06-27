<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\Entities;

use App\Customer\Domain\Model\Collections\Phones;
use App\Customer\Domain\Model\ValueObjects\Address;
use App\Customer\Domain\Model\ValueObjects\CustomerId;
use App\Customer\Domain\Model\ValueObjects\Date;
use App\Customer\Domain\Model\ValueObjects\Name;

class Customer
{
    private CustomerId $customerId;
    private Name $name;
    private Phones $phones;
    private Address $address;
    private Date $date;

    public function __construct(
        CustomerId $customerId,
        Name       $name,
        Phones     $phones,
        Address    $address,
        Date       $date,
    ) {
        $this->customerId = $customerId;
        $this->name = $name;
        $this->phones = $phones;
        $this->address = $address;
        $this->date = $date;
    }

    public function getId(): CustomerId
    {
        return $this->customerId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPhones(): Phones
    {
        return $this->phones;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getCreatedAt(): Date
    {
        return $this->date;
    }

    public function getUpdatedAt(): Date
    {
        return $this->date;
    }
}
