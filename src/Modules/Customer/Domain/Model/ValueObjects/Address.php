<?php
declare(strict_types=1);

namespace App\Modules\Customer\Domain\Model\ValueObjects;

class Address
{
    private string $country;
    private string $region;
    private string $city;
    private string $street;
    private string $house;

    public function __construct(
        string $country,
        string $region,
        string $city,
        string $street,
        string $house,
    ) {
        $this->country = $country;
        $this->region = $region;
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
    }

    public function getFull(): string
    {
        return $this->country . ' ' . $this->region . ' ' . $this->city . ' ' . $this->street . ' ' . $this->house;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getHouse(): string
    {
        return $this->house;
    }
}
