<?php

declare(strict_types=1);

require "vendor/autoload.php";

use App\Core\Router\Router;

define('VIEWS_DIR', __DIR__ . '/../src/Views');

session_start();

$router = new Router();

$router
    ->get('/', [App\Controllers\HomeController\HomeController::class, 'index'])

    ->get('/sign-up', [App\Controllers\SignupController\SignupController::class, 'index'])

    ->post('/sign-up', [App\Controllers\SignupController\SignupController::class, 'signUp'])

    ->get('/login', [App\Controllers\LoginController\LoginController::class, 'index'])

    ->post('/login', [App\Controllers\LoginController\LoginController::class, 'login'])

    ->get('/logout', [App\Controllers\LogoutController\LogoutController::class, 'logout'])

    ->get('/create-task', [App\Controllers\TaskController\TaskController::class, 'createTaskUI'])

    ->post('/create-task', [App\Controllers\TaskController\TaskController::class, 'createTaskDB'])

    ->get('/tasks', [App\Controllers\TaskController\TaskController::class, 'allTasks'])

    ->get('/task/edit', [App\Controllers\TaskController\TaskController::class, 'editTaskUI'])

    ->post('/task/edit', [App\Controllers\TaskController\TaskController::class, 'editTaskDB'])

    ->post('/task/delete', [App\Controllers\TaskController\TaskController::class, 'deleteTask'])

    ->post('/task/complete', [App\Controllers\TaskController\TaskController::class, 'completeTask']);


$router->resolve();
