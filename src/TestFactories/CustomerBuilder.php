<?php
declare(strict_types=1);

namespace App\TestFactories;

use App\Customer\Domain\Model\Collections\Phones;
use App\Customer\Domain\Model\Entities\Customer;
use App\Customer\Domain\Model\ValueObjects\Address;
use App\Customer\Domain\Model\ValueObjects\CustomerId;
use App\Customer\Domain\Model\ValueObjects\Date;
use App\Customer\Domain\Model\ValueObjects\Name;
use App\Customer\Domain\Model\ValueObjects\Phone;

class CustomerBuilder
{
    private CustomerId $id;
    private Name $name;
    private Phones $phones;
    private Address $address;
    private Date $date;

    public function __construct() {
        $this->id = CustomerId::next();
        $this->name = new Name('Ivan', 'Ivanov' , 'Ivanovich');
        $this->phones = new Phones([
            $phone1 = new Phone(7, '920', '0000001'),
            $phone2 = new Phone(7, '920', '0000002'),
        ]);
        $this->address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Ленина', '12');
        $this->date = new Date(
            new \DateTimeImmutable(\date('d.m.Y H:i:s')),
            new \DateTimeImmutable(\date('d.m.Y H:i:s')),
        );
    }

    public function withPhones(): self
    {
        return $this;
    }

    public function isActive(): self
    {
        return $this;
    }

    public function build(): Customer
    {
        return new Customer(
            $this->id,
            $this->name,
            $this->phones,
            $this->address,
            $this->date,
        );
    }
}
