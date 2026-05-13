<?php

namespace App\Domain;

class Character
{
    public function __construct(
        private readonly ?int $id,
        private int $userId,
        private ?int $apiId,
        private string $name,
        private string $species,
        private string $image,
        private string $url,
        private bool $active = true,
        private readonly string $createdAt = '',
        private string $updatedAt = '',
    ) {}

    public function getId(): ?int          { return $this->id; }
    public function getUserId(): int       { return $this->userId; }
    public function getApiId(): ?int       { return $this->apiId; }
    public function getName(): string      { return $this->name; }
    public function getSpecies(): string   { return $this->species; }
    public function getImage(): string     { return $this->image; }
    public function getUrl(): string       { return $this->url; }
    public function isActive(): bool       { return $this->active; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): string { return $this->updatedAt; }

    public function setName(string $v): void      { $this->name = $v; }
    public function setSpecies(string $v): void   { $this->species = $v; }
    public function setImage(string $v): void     { $this->image = $v; }
    public function setUrl(string $v): void       { $this->url = $v; }
    public function setActive(bool $v): void      { $this->active = $v; }
    public function setUpdatedAt(string $v): void { $this->updatedAt = $v; }

    public static function fromArray(array $data): self
    {
        return new self(
            id:        isset($data['id']) ? (int) $data['id'] : null,
            userId:    (int) ($data['user_id'] ?? 0),
            apiId:     isset($data['api_id']) ? (int) $data['api_id'] : null,
            name:      $data['name'] ?? '',
            species:   $data['species'] ?? '',
            image:     $data['image'] ?? '',
            url:       $data['url'] ?? '',
            active:    isset($data['active']) ? (bool) $data['active'] : true,
            createdAt: $data['created_at'] ?? '',
            updatedAt: $data['updated_at'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->userId,
            'api_id'     => $this->apiId,
            'name'       => $this->name,
            'species'    => $this->species,
            'image'      => $this->image,
            'url'        => $this->url,
            'active'     => $this->active ? 1 : 0,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
