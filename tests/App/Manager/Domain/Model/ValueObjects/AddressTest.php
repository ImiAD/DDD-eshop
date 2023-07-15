<?php
declare(strict_types=1);

namespace App\Manager\Domain\Model\ValueObjects;

use App\Modules\Manager\Domain\Model\ValueObjects\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testCanCreate(): void
    {
        $address = new Address('Россия', 'Смоленская обл.', 'г.Смоленск', 'ул.Сталина', '1');

        $this->assertInstanceOf(Address::class, $address);
        $this->assertSame('Россия Смоленская обл. г.Смоленск ул.Сталина 1', $address->getFull());
    }
}
