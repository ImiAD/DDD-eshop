<?php
declare(strict_types=1);

namespace App\Manager\Domain\Model\ValueObjects;

use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testCanCreate(): void
    {
        $name = new Name('Petr', 'Petrov', 'Petrovich');

        $this->assertInstanceOf(Name::class, $name);
        $this->assertSame('Petr Petrov Petrovich', $name->getFull());
    }
}
