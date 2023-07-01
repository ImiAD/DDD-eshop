<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\ValueObjects;

use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testCanCreate(): void
    {
        $phone = new Phone(7, '920', '000001');

        $this->assertInstanceOf(Phone::class, $phone);
        $this->assertSame('+7 (920) 000001', $phone->getFull());
    }
}
