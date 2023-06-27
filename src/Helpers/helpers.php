<?php

if (!function_exists('dd')) {
    function dd($data): never
    {
        echo '<pre>'; print_r($data); echo '</pre>';
        die;
    }
}

if (!function_exists('dump')) {
    function dump($data): never
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
