<?php

namespace App\Controllers\TaskController;

use App\Core\Database\Database;
use App\Core\Logger\Logger;
use App\Core\View\View;
use App\Models\Task\Task;

class TaskController
{
    public function createTaskUI()
    {
        View::render('Tasks/createTask');
    }

    public function createTaskDB()
    {
        $task = new Task($_POST);

        $isValidTask = $task->validateBasic();
        $createdTask = null;

        if ($isValidTask) {
            $createdTask = $task->create();
        } else {
            http_response_code(400);
        }

        if ($createdTask) {
            header('Location: /tasks');
            exit();
        }

        http_response_code(500);

        View::render('Tasks/createTask', [
            'title' => $task->title,
            'description' => $task->description,
            'completed' => $task->completed,
            'errors' => $task->errors,
        ]);
    }

    public function allTasks()
    {
        $user = new Task();

        $tasks = $user->getTasks();

        if (!$tasks) {
            http_response_code(500);
        }


        View::render("Tasks/showAllTasks", [
            'tasks' => $tasks,
            'notice' => $user->notice
        ]);
    }

    public function deleteTask()
    {
        $task = new Task();
        $taskId = htmlspecialchars(trim($_POST['taskId']));

        $isTaskDeleted = $task->deleteTask($taskId);

        if ($isTaskDeleted) {
            header('Location: /tasks');
            exit();
        }

        http_response_code(500);

        View::render('<h1>Something went wrong. Go back to <a href="/tasks">tasks</a>', isView: false);
    }
    public function completeTask()
    {
        $task = new Task();
        $taskId = htmlspecialchars(trim($_POST['taskId']));
        $completedStatus = filter_var($_POST['task_status'], FILTER_VALIDATE_INT);
        var_dump($completedStatus);
        if ($completedStatus === false || $completedStatus < 0 || $completedStatus > 1) {
            http_response_code(400);
        } elseif (!$task->completeTask($taskId, (int) $completedStatus)) {
            http_response_code(500);
        } else {
            header('Location: /tasks');
            exit();
        }

        View::render('<h1>Something went wrong. Go back to <a href="/tasks">tasks</a>', isView: false);
    }
}
