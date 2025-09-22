<?php

namespace App\Controllers\HomeController;

use App\Core\View\View, App\Core\Database\Database;
use App\Models\User\User;

class HomeController
{
    public function index()
    {
        $redirectPage = '';
        User::isLoggedIn() ? $redirectPage = '/tasks' : $redirectPage = '/login';
        header("Location: $redirectPage");
        exit();
    }
}
