<?php

namespace App\Domain;

class User
{
    public function __construct(
        private readonly ?int $id,
        private string $name,
        private string $email,
        private string $password,
        private readonly string $createdAt = '',
    ) {}

    public function getId(): ?int        { return $this->id; }
    public function getName(): string    { return $this->name; }
    public function getEmail(): string   { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getCreatedAt(): string { return $this->createdAt; }

    public function setName(string $name): void     { $this->name = $name; }
    public function setEmail(string $email): void   { $this->email = $email; }
    public function setPassword(string $hash): void { $this->password = $hash; }

    public static function fromArray(array $data): self
    {
        return new self(
            id:        (int) $data['id'],
            name:      $data['name'],
            email:     $data['email'],
            password:  $data['password'],
            createdAt: $data['created_at'] ?? '',
        );
    }
}
