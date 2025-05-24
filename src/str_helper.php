<?php

use RomanLazko\Str\StringProxy;

if (! function_exists('str')) {
    function str($string = null): \Stringable
    {
        return new StringProxy($string ?? '');
    }
}