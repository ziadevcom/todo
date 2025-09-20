<?php

namespace App\Controllers\NotFoundController;

use App\Core\View\View;

class NotFoundController
{
    public function index()
    {
        View::render('<h1 style="text-align: center;"> 👀 This page does not exist.</h1>', isView: false);
    }
}
