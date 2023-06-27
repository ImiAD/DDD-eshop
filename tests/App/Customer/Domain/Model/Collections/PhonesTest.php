<?php
declare(strict_types=1);

namespace App\Customer\Domain\Model\Collections;

use App\Customer\Domain\Model\ValueObjects\Phone;
use PHPUnit\Framework\TestCase;

class PhonesTest extends TestCase
{
    public function testCanCreate(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '920', '0000001'),
            $phone2 = new Phone(7, '920', '0000002'),
        ]);

        $this->assertInstanceOf(Phones::class, $phones);
        $this->assertCount(2, $phones->getAll());
        $this->assertSame([$phone1, $phone2], $phones->getAll());
    }

    public function testRemovePhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '920', '0000001'),
            $phone2 = new Phone(7, '920', '0000002'),
        ]);

        $phone = $phones->remove($phone2);

        $this->assertSame($phone2, $phone);
    }

    public function testNotRemovePhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '920', '0000001'),
            $phone2 = new Phone(7, '920', '0000002'),
        ]);

        $this->expectExceptionMessage('Такого номера телефона не существует');

        $phones->remove(new Phone(7, '920', '0000003'));
    }

    public function testCannotRemoveLastPhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '920', '0000001')],
        );

        $this->expectExceptionMessage('Последний номер телефона нельзя удалить');

        $phones->remove($phone1);
    }

    public function testGetOnePhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '921', '0000001'),
            $phone2 = new Phone(7, '922', '0000002'),
        ]);

        $phone = $phones->getOne('7921');

        $this->assertTrue($phone->equals($phone));
        $this->assertFalse($phone->equals($phone2));
    }
}
