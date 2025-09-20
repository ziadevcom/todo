<?php

namespace App\Utilities\Validator;

class Validator
{

    public static function isStrEmpty(string $input, bool $trim)
    {
        if ($trim) {
            $input = trim($input);
        }

        return $input === '' ? true : false;
    }

    public static function isValidEmail(string $input)
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL) ? true : false;
    }
}
