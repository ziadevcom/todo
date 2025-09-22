<?php

namespace App\Models\Task;

use App\Core\Database\Database;
use App\Utilities\Enums\Notice;

class Task
{
    public string $title;
    public string $description;
    public bool $completed = false;
    public array $errors = [];
    public array $notice = [];


    public function __construct(array $postData = [])
    {
        if (!empty($postData)) {
            $this->title = htmlspecialchars(trim($postData['title']));
            $this->description = htmlspecialchars(trim($postData['description']));
            $this->completed = isset($postData['completed']) && $postData['completed'] === 'on';
        }
    }

    public function validateBasic(): bool
    {

        if ($this->title === '') {
            $this->errors['title'] = "Please provide a value for title.";
            return false;
        }

        return true;
    }

    public function create(): bool
    {
        $db = Database::connect();


        $statement = $db->prepare("INSERT INTO tasks (title, description, completed, user_id) VALUES (:title, :description, :completed, :user_id)");

        $ok = $statement->execute([
            ':title' => $this->title,
            ':description' => $this->description,
            ':completed' => (int) $this->completed,
            ':user_id' => $_SESSION['user']['id']
        ]);

        if ($ok) {
            $this->notice = [
                'status' => Notice::success,
                'message' => 'Task added successfully.'
            ];
            return true;
        }

        $this->notice = [
            'status' => Notice::error,
            'message' => 'Could not add user. Please try again.'
        ];
        return false;
    }

    public function getTasks()
    {
        $userId = $_SESSION['user']['id'];
        $db = Database::connect();

        $statement = $db->prepare("SELECT * FROM tasks WHERE user_id = :userId");

        $ok = $statement->execute([
            ':userId' => $userId
        ]);

        if (!$ok) {
            $this->notice = [
                'status' => Notice::error,
                'message' => 'Could not load tasks. Please refresh the page.'
            ];
            return false;
        }

        return $statement->fetchAll();
    }

    public function deleteTask(int $taskId)
    {
        $userId = $_SESSION['user']['id'];
        $db = Database::connect();

        $statement = $db->prepare('DELETE FROM TASKS WHERE id = :taskId AND user_id = :userId');

        $ok = $statement->execute([':taskId' => $taskId, 'userId' => $userId]);

        if (!$ok) {
            $this->notice = [
                'status' => Notice::error,
                'message' => "Something went wrong. Could not delete the task."
            ];
            return false;
        }

        return true;
    }
    public function completeTask(int $taskId, $completedStatus)
    {
        $userId = $_SESSION['user']['id'];
        $db = Database::connect();

        $statement = $db->prepare('UPDATE tasks SET completed = :completed WHERE id = :taskId AND user_id = :userId');

        $ok = $statement->execute([':completed' => $completedStatus, ':taskId' => $taskId, 'userId' => $userId]);

        if (!$ok) {
            $this->notice = [
                'status' => Notice::error,
                'message' => "Something went wrong. Could not task."
            ];
            return false;
        }

        return true;
    }
}
