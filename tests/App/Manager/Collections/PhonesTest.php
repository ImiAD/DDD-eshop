<?php
declare(strict_types=1);

namespace App\Manager\Collections;

use App\Modules\Manager\Collections\Phones;
use App\Modules\Manager\Domain\Model\ValueObjects\Phone;
use PHPUnit\Framework\TestCase;

class PhonesTest extends TestCase
{
    public function testCanCreate(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '890', '000003'),
            $phone2 = new Phone(7, '661', '222226'),
        ]);

        $this->assertInstanceOf(Phones::class, $phones);
        $this->assertSame([$phone1, $phone2], $phones->getAll());
    }

    public function testRemovePhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '123', '33322'),
            $phone2 = new Phone(7, '443', '33332'),
        ]);

        $removeNumber = $phones->remove($phone2);

        $this->assertSame($phone2, $removeNumber);
    }

    public function testNotExistsPhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '555', '22322'),
            $phone2 = new Phone(7, '111', '11221'),
        ]);

        $this->expectExceptionMessage('Данный номер телефона не существует.');

        $phones->remove(new Phone(7, '111', '898989'));
    }

    public function testCannotRemoveLastPhone(): void
    {
        $phones = new Phones([
            $phone = new Phone(7, '777', '888893'),
        ]);

        $this->expectExceptionMessage('Нельзя удалить последний номер телефона.');

        $phones->remove($phone);
    }

    public function testGetOnePhone(): void
    {
        $phones = new Phones([
            $phone1 = new Phone(7, '222', '434343'),
            $phone2 = new Phone(7, '333', '444333'),
        ]);

        $phone = $phones->getOne('333');

        $this->assertTrue($phone->isEqualsTo($phone2));
        $this->assertFalse($phone->isEqualsTo($phone1));
        $this->assertSame($phone2, $phone);
    }
}
