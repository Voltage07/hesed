<?php
// users classes from the main model (user.php)

require_once __DIR__ . "/../config/url.php";
require_once __DIR__ . "/../models/User.php";

class UserController {

    private $user;

    public function __construct($db) {
        $this->user = new User($db);
    }

    public function createUser($name, $email) {
        $this->user->name  = $name;
        $this->user->email = $email;
        return $this->user->create();
    }

    public function getUsers() {
        return $this->user->read();
    }

    public function deleteUser($id) {
        $this->user->id = $id;
        return $this->user->delete();
    }

    public function searchUsers($keyword) {
        return $this->user->search($keyword);
    }

    public function showDashboard() {
        $currentPage = 'dashboard';
        $pageTitle   = 'Dashboard';

        $stmt  = $this->getUsers();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stats = [
            'total'    => count($users)
        ];

        include __DIR__ . '/../views/dashboard/index.php';
    }

    public function showList() {
        $currentPage = 'users';
        $pageTitle   = 'View Users';

        $stmt  = $this->getUsers();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/users/users.php';
    }

    public function showCreate() {
        $currentPage = 'create';
        $pageTitle   = 'Register User';

        include __DIR__ . '/../views/users/create.php';
    }

    public function showDelete() {
        $currentPage = 'delete';
        $pageTitle   = 'Delete User';

        include __DIR__ . '/../views/users/delete.php';
    }

    // API HANDLERS

    public function handleCreate() {
        header('Content-Type: application/json');
        global $base;

        $name  = trim($_POST['name']  ?? '');
        $email = trim($_POST['email'] ?? '');

        // Validations
        $errors = [];
        if (empty($name))  $errors['name']  = 'Name is required.';
        if (empty($email)) {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Enter a valid email address.';
        }

        if (!empty($errors)) {
            echo json_encode([
                'success' => false,
                'message' => 'Please fix the errors below.',
                'errors'  => $errors,
            ]);
            return;
        }

        // Check for duplicate email
        $this->user->email = $email;
        if ($this->user->emailExists()) {
            echo json_encode([
                'success' => false,
                'message' => 'That email is already registered.',
                'errors'  => ['email' => 'This email is already in use.'],
            ]);
            return;
        }

        // Create user
        $result = $this->createUser($name, $email);

        if ($result) {
            echo json_encode([
                'success'  => true,
                'message'  => 'User registered successfully.',
                'redirect' => "$base/?page=users",
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Could not register user. Please try again.',
            ]);
        }
    }

    public function handleSearch() {
        header('Content-Type: application/json');

        $keyword = trim($_GET['q'] ?? '');

        if (empty($keyword)) {
            echo json_encode([
                'success' => false,
                'message' => 'Please enter a search term.',
            ]);
            return;
        }

        $stmt  = $this->searchUsers($keyword);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'users'   => $users,
        ]);
    }

    public function handleDelete() {
        header('Content-Type: application/json');

        $id = intval($_POST['id'] ?? 0);

        if (!$id) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid user ID.',
            ]);
            return;
        }

        $result = $this->deleteUser($id);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'User deleted successfully.',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Could not delete user. They may not exist.',
            ]);
        }
    }
}