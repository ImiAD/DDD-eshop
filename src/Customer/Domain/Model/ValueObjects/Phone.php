<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\ValueObjects;

class Phone
{
    private int $country;
    private string $code;
    private string $number;

    public function __construct(int $country, string $code, string $number)
    {
        $this->country = $country;
        $this->code = $code;
        $this->number = $number;
    }

    public function getFull(): string
    {
        return '+' . $this->country . ' (' . $this->code . ') ' . $this->number;
    }

    public function isEqualTo(self $other): bool
    {
        return $this->getFull() === $other->getFull();
    }

    public function getCountry(): int
    {
        return $this->country;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getNumber(): string
    {
        return $this->number;
    }
}
