<?php
declare(strict_types=1);

namespace App\Manager\Domain\Model\ValueObjects;

use App\Modules\Manager\Domain\Model\ValueObjects\ManagerId;
use PHPUnit\Framework\TestCase;

class ManagerIdTest extends TestCase
{
    public function testCanCreate(): void
    {
        $id = ManagerId::next();

        $this->assertInstanceOf(ManagerId::class, $id);
        $this->assertTrue($id->isEqualsTo($id));
    }
}
