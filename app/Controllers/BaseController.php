<?php

namespace App\Controllers;

class BaseController
{
    protected function render($view, $data = [])
    {
        // Extrair variáveis para a view
        extract($data);
        
        // Incluir o arquivo da view
        $viewPath = __DIR__ . "/../Views/{$view}.php";
        
        if (file_exists($viewPath)) {
            ob_start();
            include $viewPath;
            $content = ob_get_clean();
            echo $content;
        } else {
            throw new \Exception("View não encontrada: {$view}");
        }
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function getPostData()
    {
        return $_POST;
    }

    protected function getQueryParam($key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    protected function setFlashMessage($type, $message)
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    protected function getFlashMessage()
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }
} 