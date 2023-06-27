<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\ValueObjects;

use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testCanCreate(): void
    {
        $addressData = [
            'Россия',
            'Смоленская обл.',
            'г.Смоленск',
            'ул.Ленина',
            '115',
        ];

        $address = new Address($addressData[0], $addressData[1], $addressData[2], $addressData[3], $addressData[4]);

        $this->assertInstanceOf(Address::class, $address);
        $this->assertSame(
            $addressData[0]
            . ' ' . $addressData[1]
            . ' ' . $addressData[2]
            . ' ' . $addressData[3]
            . ' ' . $addressData[4],
        $address->getfull());

    }
}
