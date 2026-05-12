<?php

namespace App\Application;

use App\Domain\User;
use App\Infrastructure\Repositories\UserRepository;

class AuthService
{
    public function __construct(private UserRepository $users) {}

    public function register(string $name, string $email, string $password): User
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $user = new User(null, $name, $email, $hash);
        $id   = $this->users->save($user);

        return $this->users->findById($id);
    }

    public function attempt(string $email, string $password): ?User
    {
        $user = $this->users->findByEmail($email);
        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        }

        return null;
    }

    public static function login(User $user): void
    {
        $_SESSION['user_id']   = $user->getId();
        $_SESSION['user_name'] = $user->getName();
    }

    public static function logout(): void
    {
        session_destroy();
    }

    public static function check(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public static function id(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function name(): string
    {
        return $_SESSION['user_name'] ?? '';
    }

    public static function guard(): void
    {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }
}
