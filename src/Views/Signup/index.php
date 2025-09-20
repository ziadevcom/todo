<?php

$form = [
    'action' => '/sign-up',
    'submit' => 'Sign up',
    'fields' => [
        [
            'label' => 'Email',
            'type' => 'email',
            'name' => 'email',
            'value' => $email ?? ''
        ],
        [
            'label' => 'Name',
            'type' => 'text',
            'name' => 'name',
            'value' => $name ?? ''
        ],
        [
            'label' => 'Password',
            'type' => 'password',
            'name' => 'password',
            'value' => $password ?? ''
        ]
    ]
];


include VIEWS_DIR . '/Form/index.php';

?>

<pre>
    <?= print_r($errors) ?>;
</pre>