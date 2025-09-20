<?php

namespace App\Controllers\HomeController;

use App\Core\View\View, App\Core\Database\Database;

class HomeController
{
    public function index()
    {
        $db = Database::connect();
        View::render('Home/index', ['numbers' => [random_int(100, 500000), random_int(100, 500000), random_int(100, 500000), random_int(100, 500000)]]);
    }
}
