<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\Collections;

use App\Customer\Domain\Model\ValueObjects\Phone;

class Phones
{
    private array $collection = [];

    public function __construct(array $phones)
    {
        if (!$phones) {
            throw new \DomainException('Покупатель должен иметь хотя бы один номер телефона');
        }

        foreach ($phones as $phone) {
            $this->add($phone);
        }
    }

    public function add(Phone $phone): void
    {
        foreach ($this->collection as $item) {
            if ($item->equals($phone)) {
                throw new \DomainException('Такой номер телефона уже существует');
            }
        }

        $this->collection[] = $phone;
    }

    public function remove(Phone $phone): Phone
    {
        if (!in_array($phone, $this->collection, true)) {
            throw new \DomainException('Такого номера телефона не существует');
        }

        $idx = array_search($phone, $this->collection, true);

        if ($idx === false) {
            throw new \DomainException('Такого номера телефона не существует');
        }

        if (\count($this->collection) === 1) {
            throw new \DomainException('Последний номер телефона нельзя удалить');
        }

        unset($idx);

        // а зачем здесь возвращать удаленный номер телефона?
        return $phone;
    }

    public function getAll(): array
    {
        return $this->collection;
    }

    public function getOne(string $number): ?Phone
    {
        foreach ($this->collection as $phone) {
            if (preg_match("#{$number}#", preg_replace("#[^\d]#", '', $phone->getFull()), $matches)) {
                return $phone;
            }
        }

        return null;
    }
}
