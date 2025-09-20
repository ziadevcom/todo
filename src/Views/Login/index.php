<?php

$form = [
    'action' => '/login',
    'submit' => 'Login',
    'method' => 'post',
    'fields' => [
        [
            'label' => 'Email',
            'type' => 'email',
            'name' => 'email',
            'value' => $email ?? ''
        ],
        [
            'label' => 'Password',
            'type' => 'password',
            'name' => 'password',
            'value' => $password ?? ''
        ],
    ]
];


include VIEWS_DIR . '/Form/index.php';
