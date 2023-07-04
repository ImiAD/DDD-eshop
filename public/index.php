<?php
declare(strict_types=1);
error_reporting(-1);
session_start();

require __DIR__ . '/../vendor/autoload.php';


//$customer = (new \App\TestFactories\CustomerBuilder())->build();
//
//$events = $customer->releaseEvents();
//$customerArchived = $events['CustomerArchived'];
//print_r($customerArchived);
//echo $customerArchived->getCustomerId()->getId();
//
//$query = 'SELECT is_archive FROM users WHERE id=? LIMIT 1';
//
//if (!empty($events['CustomerArchived'])) {
//    echo $customerArchived->getCustomerId()->getId();
//    echo $customerArchived->getCustomerId()->getId();
//}

$query = (new \App\Customer\Infrastructure\Database\QueryBuilder())
    ->select()
    ->from('users')
    ->where('AnD', ['id', '=', '?'], 2)
    ->where('Or', ['id', '=', '?'], 2,4)
    ->limit(100)
    ->offset()
    ->get();

print_r($query);