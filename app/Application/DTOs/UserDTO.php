<?php

namespace App\Application\DTOs;

class UserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?bool $is_admin = false
    ) {}
}
