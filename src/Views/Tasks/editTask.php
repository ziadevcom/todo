<?php
$taskId = $_GET['id'];
$form = [
    'action' => "/task/edit?id=$taskId",
    'method' => 'post',
    'submit' => 'Edit Task',
    'fields' => [
        [
            'name' => 'id',
            'label' => 'id',
            'value' => $id,
            'type' => 'hidden'
        ],
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
