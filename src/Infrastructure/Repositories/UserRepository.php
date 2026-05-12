<?php

namespace App\Infrastructure\Repositories;

use App\Domain\User;
use App\Infrastructure\Database;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        return $row ? User::fromArray($row) : null;
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? User::fromArray($row) : null;
    }

    public function save(User $user): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password) VALUES (?, ?, ?)'
        );
        $stmt->execute([$user->getName(), $user->getEmail(), $user->getPassword()]);

        return (int) $this->db->lastInsertId();
    }
}
