<?php
declare(strict_types=1);

namespace App\Manager\Domain\Model\ValueObjects;

use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testCanCreate(): void
    {
        $status = new Status($value = 'active', new \DateTimeImmutable('23-09-2023 21:21:21'));

        $this->assertSame($value, $status->getValue());
        $this->assertTrue($status->isActive());
        $this->assertSame('23-09-2023 21:21:21', $status->getDate()->format('d-m-Y H:i:s'));

        $status = new Status($value = 'archived', new \DateTimeImmutable());

        $this->assertSame($value, $status->getValue());
        $this->assertTrue($status->isArchived());
    }
}
