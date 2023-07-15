<?php
declare(strict_types=1);

namespace App\Manager\Domain\Model\ValueObjects;

use App\Modules\Manager\Domain\Model\ValueObjects\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testCanCreate(): void
    {
        $phone = new Phone(7, '890', '111110');

        $this->assertInstanceOf(Phone::class, $phone);
        $this->assertSame('+7 (890) 111110', $phone->getFull());
    }
}
