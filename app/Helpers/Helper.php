<?php

namespace App\Helpers;

class Helper
{
    public static function splitCamelCase($input)
    {
        return preg_replace('/([a-z])([A-Z])/', '$1 $2', $input);
    }
}
