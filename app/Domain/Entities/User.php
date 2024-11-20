<?php

namespace App\Domain\Entities;

class User
{
    public function __construct(
        public readonly ?int $id,
        public string $name,
        public string $email,
        public ?string $password = null,
        public ?bool $is_admin = false,
        public ?string $created_at,
    ) {}

    /**
     * Convert the user object to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'is_admin' => $this->is_admin,
            'created_at' => $this->created_at,
        ];
    }

    /**
     * Factory method to create a User from an array.
     *
     * @param array $data
     * @return self
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null,
            is_admin: $data['is_admin'] ?? false,
            created_at: $data['created_at'] ?? null,
        );
    }
}
