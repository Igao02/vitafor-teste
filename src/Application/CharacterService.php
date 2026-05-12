<?php

namespace App\Application;

use App\Domain\Character;
use App\Infrastructure\Repositories\CharacterRepository;

class CharacterService
{
    public function __construct(private CharacterRepository $characters) {}

    public function save(int $userId, array $data): Character
    {
        $character = Character::fromArray([
            'user_id'  => $userId,
            'api_id'   => $data['api_id'] ?? null,
            'name'     => $data['name'] ?? '',
            'species'  => $data['species'] ?? '',
            'gender'   => $data['gender'] ?? '',
            'location' => $data['location'] ?? '',
            'image'    => $data['image'] ?? '',
            'url'      => $data['url'] ?? '',
        ]);

        $id = $this->characters->save($character);
        return $this->characters->findById($id);
    }

    public function update(int $id, int $userId, array $data): ?Character
    {
        $character = $this->characters->findById($id);
        if (!$character || $character->getUserId() !== $userId) {
            return null;
        }

        $character->setName($data['name'] ?? $character->getName());
        $character->setSpecies($data['species'] ?? $character->getSpecies());
        $character->setGender($data['gender'] ?? $character->getGender());
        $character->setLocation($data['location'] ?? $character->getLocation());
        $character->setImage($data['image'] ?? $character->getImage());
        $character->setUrl($data['url'] ?? $character->getUrl());

        $this->characters->update($character);
        return $character;
    }

    public function delete(int $id, int $userId): bool
    {
        return $this->characters->delete($id, $userId);
    }
}
