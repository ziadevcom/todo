<?php

namespace App\Controllers\LogoutController;

class LogoutController
{

    public function logout()
    {
        session_start();

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', [
                'expires' => time() - 3600,
                'path' => '/'
            ]);
        }

        $_SESSION = [];

        session_destroy();

        header('Location: /login');

        exit();
    }
}
