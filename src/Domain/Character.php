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
        private string $gender,
        private string $location,
        private string $image,
        private string $url,
        private readonly string $createdAt = '',
        private string $updatedAt = '',
    ) {}

    public function getId(): ?int          { return $this->id; }
    public function getUserId(): int       { return $this->userId; }
    public function getApiId(): ?int       { return $this->apiId; }
    public function getName(): string      { return $this->name; }
    public function getSpecies(): string   { return $this->species; }
    public function getGender(): string    { return $this->gender; }
    public function getLocation(): string  { return $this->location; }
    public function getImage(): string     { return $this->image; }
    public function getUrl(): string       { return $this->url; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): string { return $this->updatedAt; }

    public function setName(string $name): void       { $this->name = $name; }
    public function setSpecies(string $v): void       { $this->species = $v; }
    public function setGender(string $v): void        { $this->gender = $v; }
    public function setLocation(string $v): void      { $this->location = $v; }
    public function setImage(string $v): void         { $this->image = $v; }
    public function setUrl(string $v): void           { $this->url = $v; }
    public function setUpdatedAt(string $v): void     { $this->updatedAt = $v; }

    public static function fromArray(array $data): self
    {
        return new self(
            id:        isset($data['id']) ? (int) $data['id'] : null,
            userId:    (int) ($data['user_id'] ?? 0),
            apiId:     isset($data['api_id']) ? (int) $data['api_id'] : null,
            name:      $data['name'] ?? '',
            species:   $data['species'] ?? '',
            gender:    $data['gender'] ?? '',
            location:  $data['location'] ?? '',
            image:     $data['image'] ?? '',
            url:       $data['url'] ?? '',
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
            'gender'     => $this->gender,
            'location'   => $this->location,
            'image'      => $this->image,
            'url'        => $this->url,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
