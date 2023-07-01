<?php
declare(strict_types=1);

namespace App\Factories;

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
     private Address $address;
     private array $phones;
     private Date $date;
     private bool $archived = false;

     public function __construct()
     {
         $this->id = CustomerId::next();
         $this->name = new Name('Ivan', 'Ivanov', 'Ivanovich');
         $this->address = new Address('Россия','Смоленская обл.', 'г.Смоленск', 'ул.Ленина', '1');
         $this->phones[] = new Phone(7, '921', '000001');
         $this->date = new Date(
             new \DateTimeImmutable('2023-06-28 11:51:00'),
             new \DateTimeImmutable('2023-06-28 11:51:01'),
         );
     }

     public function withId(CustomerId $customerId): self
     {
         $clone = clone $this;
         $clone->id = $customerId;

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

     public function build(): Customer
     {
         $customer = new Customer(
             $this->id,
             $this->name,
             $this->address,
             $this->phones,
             $this->date,
         );

         if ($this->archived) {
             $customer->archive(new \DateTimeImmutable());
         }

         return $customer;
     }
}
