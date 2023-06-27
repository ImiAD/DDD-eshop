<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\ValueObjects;

class CustomerId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public static function next(): self
    {
        return new self(uuId());
    }

    public function equals(self $object): bool
    {
        return $this->getId() === $object->getId();
    }
}
