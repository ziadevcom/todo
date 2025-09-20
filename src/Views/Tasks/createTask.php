<?php
$form = [
    'action' => '/create-task',
    'method' => 'post',
    'submit' => 'Create Task',
    'fields' => [
        [
            'name' => 'title',
            'label' => 'Title',
            'value' => $title ?? '',
            'type' => 'text'
        ],
        [
            'name' => 'description',
            'label' => 'Description',
            'value' => $description ?? '',
            'type' => 'textarea'
        ],
        [
            'name' => 'completed',
            'label' => 'Task Finished',
            'value' => $completed ?? false,
            'type' => 'checkbox',
        ],
    ]
];

include VIEWS_DIR . '/Form/index.php';
