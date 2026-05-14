<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Character;
use App\Infrastructure\Database;
use PDO;

class CharacterRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM characters WHERE active = 1 ORDER BY created_at DESC');
        return array_map(fn($row) => Character::fromArray($row), $stmt->fetchAll());
    }

    public function findByUserId(int $userId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM characters WHERE user_id = ? AND active = 1 ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return array_map(fn($row) => Character::fromArray($row), $stmt->fetchAll());
    }

    public function findById(int $id): ?Character
    {
        $stmt = $this->db->prepare('SELECT * FROM characters WHERE id = ? AND active = 1 LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? Character::fromArray($row) : null;
    }

    public function save(Character $character): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO characters (user_id, api_id, name, species, image, url)
            VALUES (?, ?, ?, ?, ?, ?)
        ');
        $stmt->execute([
            $character->getUserId(),
            $character->getApiId(),
            $character->getName(),
            $character->getSpecies(),
            $character->getImage(),
            $character->getUrl(),
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(Character $character): void
    {
        $stmt = $this->db->prepare('
            UPDATE characters
            SET name = ?, species = ?, image = ?, url = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ? AND user_id = ?
        ');
        $stmt->execute([
            $character->getName(),
            $character->getSpecies(),
            $character->getImage(),
            $character->getUrl(),
            $character->getId(),
            $character->getUserId(),
        ]);
    }

    public function findIdByApiId(int $userId, int $apiId): ?int
    {
        $stmt = $this->db->prepare('SELECT id FROM characters WHERE user_id = ? AND api_id = ? AND active = 1 LIMIT 1');
        $stmt->execute([$userId, $apiId]);
        $row = $stmt->fetch();
        return $row ? (int) $row['id'] : null;
    }

    public function delete(int $id, int $userId): bool
    {
        $stmt = $this->db->prepare('UPDATE characters SET active = 0 WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);

        return $stmt->rowCount() > 0;
    }
}
