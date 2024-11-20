<?php

namespace App\Application\UseCases\Users;

use App\Domain\Repositories\IUserRepositoryInterface;
use App\Domain\Entities\User as UserEntity;

class GetUserById
{
    public function __construct(private readonly IUserRepositoryInterface $userRepository) {}

    public function execute(int $id): ?UserEntity
    {
        return $this->userRepository->getById($id);
    }
}
