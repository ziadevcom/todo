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

        if ($tasks === false) {
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
        $taskId = filter_input(INPUT_POST, 'taskId', FILTER_VALIDATE_INT);
        $fetchedTask = $task->getById($taskId);

        $errorMessage = 'Something went wrong.';
        $httpCode = 200;

        if (!$fetchedTask) {
            $httpCode = 400;
            $errorMessage = "No task id provided.";
        } elseif ((int) $fetchedTask['user_id'] !== (int) $_SESSION['user']['id']) {
            $httpCode = 403;
            $errorMessage = 'You do not have permissions to delete this task.';
        } elseif ($task->delete($taskId)) {
            header('Location: /tasks');
            exit();
        } else {
            $httpCode = 500;
        }

        http_response_code($httpCode);

        View::render("<h1>$errorMessage Go back to <a href='/tasks'>tasks</a>", isView: false);
    }

    public function completeTask()
    {
        $task = new Task();
        $taskId =  filter_input(INPUT_POST, 'taskId', FILTER_VALIDATE_INT);
        $completedStatus = filter_input(INPUT_POST, 'task_status', FILTER_VALIDATE_INT);

        if ($completedStatus === false || $completedStatus < 0 || $completedStatus > 1) {
            http_response_code(400);
        } elseif (!$task->complete($taskId, (int) $completedStatus)) {
            http_response_code(500);
        } else {
            header('Location: /tasks');
            exit();
        }

        View::render('<h1>Something went wrong. Go back to <a href="/tasks">tasks</a>', isView: false);
    }

    public function editTaskUI()
    {
        $taskId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $errorMessage = 'Something went wrong';
        $errorCode = 200;

        if (!$taskId) {
            http_response_code(400);
            return View::render('Please provide a valid task id.', isView: false);
        }

        $task = new Task();
        $fetchedTask = $task->getById($taskId);

        if (!$fetchedTask) {
            http_response_code(404);
            return View::render('No task found with that task id.', isView: false);
        }

        if ($fetchedTask['user_id'] != $_SESSION['user']['id']) {
            http_response_code(403);
            return View::render('You do not have permission to edit this task.', isView: false);
        }

        View::render('Tasks/editTask', $fetchedTask);
    }

    public function editTaskDB()
    {
        $task = new Task($_POST);

        if (!$task->id) {
            http_response_code(400);
            return View::render('Invalid task id provided.', isView: false);
        }

        $isValidUserInput = $task->validateBasic();

        if (!$isValidUserInput) {
            http_response_code(400);

            return View::render('Tasks/editTask', [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'completed' => $task->completed,
                'errors' => $task->errors,
            ]);
        }

        $fetchedTask = $task->getById($task->id);

        if (!$fetchedTask) {
            http_response_code(404);
            return View::render('Could not find a task with that id.', isView: false);
        }

        $doesTaskBelongToUser = $fetchedTask['user_id'] == $_SESSION['user']['id'];

        if (!$doesTaskBelongToUser) {
            http_response_code(403);
            return View::render('You do not have persmission to edit this task.', isView: false);
        }

        if ($task->edit()) {
            header('Location: /tasks');
            exit();
        }

        http_response_code(500);
        return View::render('Something went wrong.', isView: false);
    }
}
