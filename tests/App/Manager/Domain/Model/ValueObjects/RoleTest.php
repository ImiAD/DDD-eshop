<?php
declare(strict_types=1);

namespace App\Manager\Domain\Model\ValueObjects;

use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    public function testCanCreate(): void
    {
        $role = new Role('Admin', new \DateTimeImmutable('02-07-2023 10:23:01'));

        $this->assertInstanceof(Role::class, $role);
        $this->assertSame('admin', $role->getValue());
        $this->assertSame('02-07-2023 10:23:01', $role->getDate()->format('d-m-Y H:i:s'));
        $this->assertTrue($role->isEqualsTo($role));
    }
}
