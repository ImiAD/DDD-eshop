<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\ValueObjects;

class Date
{
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAT;

    public function __construct(\DateTimeImmutable $createdAt, \DateTimeImmutable $updatedAT)
    {
        $this->createdAt = $createdAt;
        $this->updatedAT = $updatedAT;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAT(): \DateTimeImmutable
    {
        return $this->updatedAT;
    }
}
