<?php
declare(strict_types=1);

namespace App\Modules\Manager\Domain\Model\ValueObjects;

class ManagerId
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

    public function isEqualsTo(self $object): bool
    {
        return $this->getId() === $object->getId();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
