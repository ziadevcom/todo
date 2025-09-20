<?php

namespace App\Controllers\LoginController;

use App\Core\View\View;
use App\Models\User\User;
use App\Utilities\Validator\Validator;

class LoginController
{
    public function index()
    {
        View::render('Login/index');
    }

    public function login()
    {
        $user = new User($_POST);

        $isValidUser = $user->validateLogin();

        if (!$isValidUser) {
            http_response_code(400);
            View::render('/Login/index', [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'errors' => $user->errors,
                'notice' => $user->notice
            ]);
            return;
        }

        $user->login();
        header('Location: /account');
    }
}
