<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\ValueObjects;

use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testCanCreate(): void
    {
        $phone = new Phone(7, '920', '0000001');

        $this->assertInstanceOf(Phone::class, $phone);
        $this->assertSame(7, $phone->getCountry());
        $this->assertSame('920', $phone->getCode());
        $this->assertSame('0000001', $phone->getNumber());
        $this->assertSame('+7 (920) 0000001', $phone->getFull());

        $phone2 = new Phone(7, '920', '0000001');

        $this->assertTrue($phone->equals($phone2));
    }
}
