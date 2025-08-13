<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// Configuração de erros para desenvolvimento
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Roteamento simples
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Remover query string da URL
$request = parse_url($request, PHP_URL_PATH);

// Rotas
$routes = [
    'GET' => [
        '/' => ['App\Controllers\AuthController', 'loginForm'],
        '/login' => ['App\Controllers\AuthController', 'loginForm'],
        '/logout' => ['App\Controllers\AuthController', 'logout'],
        '/dashboard' => ['App\Controllers\DashboardController', 'index'],
        '/areas' => ['App\Controllers\AreaController', 'index'],
        '/areas/create' => ['App\Controllers\AreaController', 'create'],
        '/areas/edit' => ['App\Controllers\AreaController', 'edit'],
        '/alunos' => ['App\Controllers\AlunoController', 'index'],
        '/alunos/create' => ['App\Controllers\AlunoController', 'create'],
        '/alunos/edit' => ['App\Controllers\AlunoController', 'edit'],
        '/matriculas' => ['App\Controllers\MatriculaController', 'index'],
        '/matriculas/create' => ['App\Controllers\MatriculaController', 'create'],
        '/matriculas/edit' => ['App\Controllers\MatriculaController', 'edit']
    ],
    'POST' => [
        '/login' => ['App\Controllers\AuthController', 'login'],
        '/logout' => ['App\Controllers\AuthController', 'logout'],
        '/areas/store' => ['App\Controllers\AreaController', 'store'],
        '/areas/update' => ['App\Controllers\AreaController', 'update'],
        '/areas/delete' => ['App\Controllers\AreaController', 'delete'],
        '/alunos/store' => ['App\Controllers\AlunoController', 'store'],
        '/alunos/update' => ['App\Controllers\AlunoController', 'update'],
        '/alunos/delete' => ['App\Controllers\AlunoController', 'delete'],
        '/matriculas/store' => ['App\Controllers\MatriculaController', 'store'],
        '/matriculas/update' => ['App\Controllers\MatriculaController', 'update'],
        '/matriculas/delete' => ['App\Controllers\MatriculaController', 'delete']
    ]
];

// Verificar se a rota existe
if (isset($routes[$method][$request])) {
    [$controllerClass, $method] = $routes[$method][$request];
    
    // Verificar autenticação para rotas protegidas
    if ($request !== '/' && $request !== '/login' && !isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
    
    $controller = new $controllerClass();
    $controller->$method();
} else {
    // Página 404
    http_response_code(404);
    echo '<h1>Página não encontrada</h1>';
    echo '<p>A página que você está procurando não existe.</p>';
    echo '<a href="/">Voltar ao início</a>';
} 