<?php

declare(strict_types=1);

use App\Infrastructure\Controller\RegisterUserController;

$container = require_once __DIR__ . '/../src/bootstrap.php';

// Simple router
$path = $_SERVER['PATH_INFO'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($path === '/api/users' && $method === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true) ?? [];
    $controller = new RegisterUserController($container['registerUserUseCase']);
    $response = $controller($requestData);
    
    echo json_encode($response);
    exit;
}

// Return 404 if no route matches
http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Not found']);