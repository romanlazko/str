<?php

use RomanLazko\Str\StringProxy;

if (! function_exists('str')) {
    function str($string = null): StringProxy
    {
        return new StringProxy($string ?? '');
    }
}