<?php
declare(strict_types=1);

namespace App\Manager\Domain\Model\ValueObjects;

class Role
{
    public const ADMIN = 'admin';
    public const SENIOR_MANAGER = 'senior_manager';
    public const MANAGER_ASSISTANT = 'manager_assistant';
    public const STOREKEEPER = 'storekeeper';
    public const ROLES = [self::ADMIN, self::SENIOR_MANAGER, self::MANAGER_ASSISTANT, self::STOREKEEPER];
    private string $value;
    private \DateTimeImmutable $date;

    public function __construct(string $value, \DateTimeImmutable $date)
    {
        if (!in_array(lower($value), self::ROLES)) {
            throw new \DomainException('Такой роли нет в нашей организации.');
        }

        $this->value = lower($value);
        $this->date = $date;
    }

    public function isStorekeeper(): bool
    {
        return $this->value === self::STOREKEEPER;
    }

    public function isManagerAssistant(): bool
    {
        return $this->value === self::MANAGER_ASSISTANT;
    }

    public function isSeniorManager(): bool
    {
        return $this->value === self::SENIOR_MANAGER;
    }

    public function isAdmin(): bool
    {
        return $this->value === self::ADMIN;
    }

    public function isEqualsTo(self $object): bool
    {
        return $this->getValue() === $object->getValue();
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
