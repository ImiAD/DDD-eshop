<?php
declare(strict_types=1);

namespace App\Customer\Collections;

use App\Modules\Customer\Collections\Phones;
use App\Modules\Customer\Domain\Model\ValueObjects\Phone;
use PHPUnit\Framework\TestCase;

class PhonesTest extends TestCase
{
    public function testCanCreate(): void
    {
        $phones = new \App\Modules\Customer\Collections\Phones([
            $phone1 = new Phone(7, '921', '000001'),
            $phone2 = new Phone(7, '922', '000002'),
        ]);

        $this->assertInstanceOf(Phones::class, $phones);
        $this->assertSame([$phone1, $phone2], $phones->getAll());
    }

    public function testAddPhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '921', '000001'),
        ]);

        $this->expectExceptionMessage('Такой номер телефона уже существует.');

        $phones->add(new Phone(7, '921', '000001'));
    }

    public function testRemovePhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '921', '000001'),
            $phone2 = new Phone(7, '922', '000002'),
        ]);

        $phone = $phones->remove($phone2);

        $this->assertSame($phone2, $phone);
    }

    public function testNotExistsPhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '921', '000001'),
            $phone2 = new Phone(7, '922', '000002'),
        ]);

        $this->expectExceptionMessage('Такой номер телефона не существует.');

        $phones->remove(new Phone(7, '923', '000003'));
    }

    public function testCannotRemoveLastPhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '921', '000001'),
        ]);

        $this->expectExceptionMessage('Нельзя удалить последний номер телефона.');

//        $phones->remove($phone1);
        $phones->remove(new Phone(7, '921', '000001'));
    }

    public function testGetOnePhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '921', '000001'),
            $phone2 = new Phone(7, '922', '000002'),
        ]);

        $phone = $phones->getOne('9220');

        $this->assertTrue($phone->isEqualTo($phone2));
        $this->assertFalse($phone->isEqualTo($phone1));
        $this->assertSame($phone2, $phone);
    }
}
