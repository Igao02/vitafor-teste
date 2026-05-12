<?php

namespace App\Presentation\Controllers;

use App\Application\AuthService;
use App\Infrastructure\Repositories\UserRepository;
use App\Presentation\Request;

class AuthController
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService(new UserRepository());
    }

    public function loginForm(Request $request, array $params = []): void
    {
        if (AuthService::check()) {
            header('Location: /');
            exit;
        }

        $error = $_SESSION['auth_error'] ?? null;
        unset($_SESSION['auth_error']);
        require BASE_PATH . '/views/auth/login/index.php';
    }

    public function login(Request $request, array $params = []): void
    {
        $email    = trim($request->post('email', ''));
        $password = $request->post('password', '');

        $user = $this->auth->attempt($email, $password);

        if (!$user) {
            $_SESSION['auth_error'] = 'E-mail ou senha inválidos.';
            header('Location: /login');
            exit;
        }

        AuthService::login($user);
        header('Location: /');
        exit;
    }

    public function registerForm(Request $request, array $params = []): void
    {
        if (AuthService::check()) {
            header('Location: /');
            exit;
        }

        $error = $_SESSION['auth_error'] ?? null;
        unset($_SESSION['auth_error']);
        require BASE_PATH . '/views/auth/register/index.php';
    }

    public function register(Request $request, array $params = []): void
    {
        $name     = trim($request->post('name', ''));
        $email    = trim($request->post('email', ''));
        $password = $request->post('password', '');
        $confirm  = $request->post('password_confirm', '');

        if (!$name || !$email || !$password) {
            $_SESSION['auth_error'] = 'Preencha todos os campos.';
            header('Location: /register');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['auth_error'] = 'E-mail inválido.';
            header('Location: /register');
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['auth_error'] = 'A senha deve ter ao menos 6 caracteres.';
            header('Location: /register');
            exit;
        }

        if ($password !== $confirm) {
            $_SESSION['auth_error'] = 'As senhas não coincidem.';
            header('Location: /register');
            exit;
        }

        try {
            $user = $this->auth->register($name, $email, $password);
            AuthService::login($user);
            header('Location: /');
            exit;
        } catch (\Exception) {
            $_SESSION['auth_error'] = 'Este e-mail já está cadastrado.';
            header('Location: /register');
            exit;
        }
    }

    public function logout(Request $request, array $params = []): void
    {
        AuthService::logout();
        header('Location: /login');
        exit;
    }
}
