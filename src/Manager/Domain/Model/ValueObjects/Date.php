<?php
declare(strict_types=1);

namespace App\Manager\Domain\Model\ValueObjects;

class Date
{
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(\DateTimeImmutable $createdAt, \DateTimeImmutable $updatedAt)
    {
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
