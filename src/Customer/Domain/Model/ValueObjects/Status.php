<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\ValueObjects;

class Status
{
    public const ACTIVE = 'active';
    public const ARCHIVED = 'archived';

    private string $value;
    private \DateTimeImmutable $date;

    public function __construct(string $value, \DateTimeImmutable $date)
    {
        $this->value = $value;
        $this->date = $date;
    }

    public function isActive(): bool
    {
        return $this->value === self::ACTIVE;
    }

    public function isArchived(): bool
    {
        return $this->value === self::ARCHIVED;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}
