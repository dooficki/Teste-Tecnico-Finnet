<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    public function loginForm()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }
        
        $this->render('auth/login', [
            'title' => 'Login - Plataforma de Ensino'
        ]);
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Credenciais fixas para o teste (em produção seria um banco de dados)
        if ($email === 'admin@jubilut.com' && $password === 'admin123') {
            $_SESSION['user_id'] = 1;
            $_SESSION['user_name'] = 'Administrador';
            $_SESSION['user_email'] = $email;
            
            $this->setFlashMessage('success', 'Login realizado com sucesso!');
            $this->redirect('/dashboard');
        } else {
            $this->setFlashMessage('danger', 'Email ou senha incorretos!');
            $this->redirect('/login');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }
} 