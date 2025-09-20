<?php

namespace App\Core\Logger;

class Logger
{
    public static function print(...$data)
    {

        echo '<pre>';
        foreach ($data as $d) {
            print_r($d);
        }
        echo '</pre>';
    }
}
