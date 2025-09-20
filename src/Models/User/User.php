<?php

namespace App\Models\User;

use App\Core\Database\Database;
use App\Core\Logger\Logger;
use InvalidArgumentException;
use App\Utilities\Enums\Notice;


class User
{
    private array $postRequestData = [];
    private string $name;
    private string $email;
    private string $password;
    public array $errors = [];
    public ?array $notice = null;
    private ?array $loggedInUserData = null;

    public function __construct(array $postData)
    {
        $this->postRequestData = $postData;
        $this->name      = htmlspecialchars(trim($this->postRequestData['name'] ?? ''));
        $this->email     = htmlspecialchars(trim($this->postRequestData['email']));
        $this->password  = htmlspecialchars(trim($this->postRequestData['password']));
    }
    public function validateSignup(): bool
    {
        $email = $this->email;
        $password = $this->password;

        foreach (['name', 'email', 'password'] as $fieldName) {
            if ($this->$fieldName === '') {
                $this->errors[$fieldName] = "Please provide a value for $fieldName.";
            }
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Please provid a valid email.";
        }

        if (strlen($password) < 7) {
            $this->errors['password'] = "Password length should be at least 7 characters.";
        }

        $db = Database::connect();

        $statement = $db->prepare('Select * FROM users WHERE email = :email');
        $statement->execute([':email' => $email]);
        $user = $statement->fetch();

        if ($user) {
            $this->notice = [
                'status' => Notice::error,
                'message' => 'A user already registered with the email provided.'
            ];
        }


        return count($this->errors) > 0 || $this->notice !== null  ? false : true;
    }

    public function validateLogin()
    {
        $email = $this->email;
        $password = $this->password;

        foreach (['email', 'password'] as $fieldName) {
            if ($this->$fieldName === '') {
                $this->errors[$fieldName] = "Please provide a value for $fieldName.";
            }
        }

        if (count($this->errors) > 0) {
            return false;
        }

        $user = $this->getbyEmail($email);

        if (!$user) {
            $this->notice = [
                'status' => Notice::error,
                'message' => 'No user registered with the email provided.'
            ];
            return false;
        }

        $hash = $user['password'];

        $isPasswordCorrect = password_verify($password, $hash);
        if (!$isPasswordCorrect) {
            $this->notice = [
                'status' => Notice::error,
                'message' => "Invalid credentials provided."
            ];
            return false;
        }

        // $this->loggedInUserData = ['name' => $user['name'], 'email' => $user['email']];
        $this->loggedInUserData = $user;
        return true;
    }

    public function login()
    {

        $sessionDuration = 3600 * 24 * 7; // 1 week

        session_set_cookie_params([
            'lifetime' => $sessionDuration,  // 1 week 
            'path' => '/',
            'secure' => true,    // only over HTTPS
            'httponly' => true,  // not accessible via JavaScript
            'samesite' => 'Lax'  // or 'Strict'
        ]);

        ini_set('session.gc_maxlifetime', $sessionDuration);

        session_start();

        $_SESSION['user'] = $this->loggedInUserData;
    }
    public function create()
    {
        $db = Database::connect();
        $statement = $db->prepare('INSERT INTO users (name, email, password, email_verified) VALUES (:name, :email, :password, :isEmailVerified)');

        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $ok = $statement->execute([
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => $hashedPassword,
            ':isEmailVerified' => true
        ]);

        if ($ok) {
            $this->notice = [
                'status' => Notice::success,
                'message' => 'User added successfully. Please verify your email.'
            ];
            return true;
        }

        $this->notice = [
            'status' => Notice::error,
            'message' => 'Could not add user. Please try again.'
        ];

        return false;
    }

    private static function getByOne(string $column, string $value): bool|array
    {
        $allowed_columns = ['id', 'email'];

        if (!in_array($column, $allowed_columns)) {
            throw new InvalidArgumentException('Invalid column provided.');
        }

        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM users WHERE $column = :$column");
        $statement->execute([":$column" => $value]);
        return $statement->fetch();
    }

    public static function getbyEmail(string $email): bool|array
    {
        return self::getByOne('email', $email);
    }

    public static function getById(string $id): bool|array
    {

        return self::getByOne('id', $id);
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }
}
