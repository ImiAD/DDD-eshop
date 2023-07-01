<?php

if (!function_exists('dd')) {
    function dd(mixed $data): never
    {
        echo '<pre>'; print_r($data); echo '</pre>';
        die;
    }
}

if (!function_exists('dump')) {
    function dump(mixed $data): never
    {
        echo '<pre>'; var_dump($data); echo '</pre>';
        die;
    }
}

if (!function_exists('uuId')) {
    function uuId(): string
    {
        return uniqid('', true) . time();
    }
}

if (!function_exists('getClassName')) {
    function getClassName(object $object): string
    {
        $parts = explode('\\', get_class($object));

        return end($parts);
    }
}