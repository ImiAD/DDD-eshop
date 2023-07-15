<?php
declare(strict_types=1);

namespace App\Modules\Customer\Domain\Model\ValueObjects;

class CustomerId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function next(): self
    {
        return new self(uuId());
    }

    public function isEqualsTo(self $other): bool
    {
        return $this->getId() === $other->getId();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
