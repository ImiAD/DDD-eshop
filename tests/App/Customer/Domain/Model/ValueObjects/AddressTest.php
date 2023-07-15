<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\ValueObjects;

use App\Modules\Customer\Domain\Model\ValueObjects\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testCanCreate(): void
    {
        $address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Ленина', '1');

        $this->assertInstanceOf(Address::class, $address);
        $this->assertSame('Россия Смоленская обл. г.Смоленск ул.Ленина 1', $address->getFull());
    }
}
