<?php
declare(strict_types=1);

namespace App\Modules\Customer\Domain\Model\ValueObjects;

class Name
{
    private string $firstName;
    private string $lastName;
    private string $middleName;

    public function __construct(string $firstName, string $lastName, string $middleName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
    }

    public function getFull(): string
    {
        return $this->firstName . ' ' . $this->lastName . ' ' . $this->middleName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }
}
