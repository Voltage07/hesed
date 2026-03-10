<?php

/*index.php — Entry point*/

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/controllers/Users_c.php';

// db connection
$database   = new Database();
$db         = $database->connect();
$controller = new UserController($db);

$page   = $_GET['page']   ?? 'dashboard';
$action = $_GET['action'] ?? '';


// API handlers
if (!empty($action)) {
    match($action) {
        'create'     => $controller->handleCreate(),
        'userSearch' => $controller->handleSearch(),
        'delete'     => $controller->handleDelete(),
        default      => http_response_code(404),
    };
    exit;
}

// Page loads
match($page) {
    'users'  => $controller->showList(),
    'create' => $controller->showCreate(),
    'delete' => $controller->showDelete(),
    default  => $controller->showDashboard(),
};