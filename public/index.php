<?php
declare(strict_types=1);
error_reporting(-1);
session_start();

require __DIR__ . '/../vendor/autoload.php';

$customer = (new \App\TestFactories\CustomerBuilder())->build();
//$customer2 = (new \App\TestFactories\CustomerBuilder())->withPhones([
//    new \App\Modules\Customer\Domain\Model\ValueObjects\Phone(7, '925', '0000001'),
//    new \App\Modules\Customer\Domain\Model\ValueObjects\Phone(7, '922', '0000002'),
//])->build();

$driver = \App\Kernel\Database\PDODriver::getInstance();
$repository = new \App\Modules\Customer\Infrastructure\Doctrine\PDOCustomerRepository($driver);
$result = $repository->create($customer);
////$repository->create($customer);
////$result = $repository->all();
////$repository->remove($customer);
//$result = $repository->update($customer->getId()->getId(), $customer2);
dump($result);
