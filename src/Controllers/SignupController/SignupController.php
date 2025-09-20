<?php

namespace App\Controllers\SignupController;

use App\Core\View\View;
use App\Models\User\User;

class SignupController
{
    public function index()
    {
        View::render('Signup/index');
    }

    public function signUp()
    {
        $user = new User($_POST);
        $statusCode = 201;

        $isUserInfoValid = $user->validateSignup();

        if (!$isUserInfoValid) {
            $statusCode = 400;
        } else if (!$user->create()) {
            $statusCode = 500;
        }

        http_response_code($statusCode);

        View::render('Signup/index', array_merge([
            'errors' => $user->errors,
            'notice' => $user->notice
        ], $_POST));
    }
}
