<?php
declare(strict_types=1);

namespace App\Manager\Collections;

use App\Manager\Domain\Model\ValueObjects\Phone;

class Phones
{
    private array $phones = [];

    public function __construct(array $phones)
    {
        if (!$phones) {
            throw new \DomainException('У менеджер должен быть хотя бы один номер телефона.');
        }

        foreach ($phones as $item) {
            $this->add($item);
        }
    }

    public function add(Phone $phone): void
    {
        foreach ($this->phones as $item) {
            if ($item->isEqualsTo($phone)) {
                throw new \DomainException('Такой номер телефона уже существует.');
            }
        }

        $this->phones[] = $phone;
    }

    public function remove(Phone $phone): Phone
    {
        $idx = array_search($phone, $this->phones);

        if ($idx === false) {
            throw new \DomainException('Данный номер телефона не существует.');
        }

        if (\count($this->phones) === 1) {
            throw new \DomainException('Нельзя удалить последний номер телефона.');
        }

        $oldPhone = $this->phones[$idx];
        unset($this->phones[$idx]);

        return $oldPhone;
    }

    public function getOne(string $number): ?Phone
    {
        foreach ($this->phones as $phone) {
            if (preg_match("#{$number}#", preg_replace("#[^\d]#", '', $phone->getFull()), $matches)) {
                return $phone;
            }
        }

        return null;
    }

    public function getAll(): array
    {
        return $this->phones;
    }
}
