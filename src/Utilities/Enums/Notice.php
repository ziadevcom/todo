<?php

namespace App\Utilities\Enums;

enum Notice: string
{
    case warning = 'warning';
    case error = 'error';
    case success = 'success';
}
