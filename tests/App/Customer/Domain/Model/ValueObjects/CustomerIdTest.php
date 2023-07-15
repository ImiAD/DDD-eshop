<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\ValueObjects;

use App\Modules\Customer\Domain\Model\ValueObjects\CustomerId;
use PHPUnit\Framework\TestCase;

class CustomerIdTest extends TestCase
{
    public function testCanCreate(): void
    {
        $id = CustomerId::next();

        $this->assertInstanceOf(CustomerId::class, $id);
        $this->assertTrue($id->isEqualsTo($id));
    }
}
