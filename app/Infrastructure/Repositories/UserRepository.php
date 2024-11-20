<?php

namespace App\Infrastructure\Repositories;

use App\Presentation\Models\User;
use App\Domain\Repositories\IUserRepositoryInterface;

class UserRepository extends Repository implements IUserRepositoryInterface
{
    public function getDefaultAdminUser(): User
    {
        return User::query()->where('is_admin', true)->oldest()->first();
    }

    public function findOneByEmail(string $email): ?User
    {
        return User::query()->firstWhere('email', $email);
    }
}
