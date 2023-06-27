<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\ValueObjects;

use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testCanCreate(): void
    {
        $name = new Name('Ivan', 'Ivanov', 'Ivanovich');

        $this->assertInstanceOf(Name::class, $name);
        $this->assertSame('Ivan Ivanov Ivanovich', $name->getFull());
    }
}
