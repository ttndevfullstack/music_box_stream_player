<?php

namespace App\Application\UseCases\Users;

use App\Domain\Repositories\IUserRepositoryInterface;

class DeleteUser
{
    public function __construct(private readonly IUserRepositoryInterface $userRepository) {}

    public function execute(int $id)
    {
        return $this->userRepository->delete($id);
    }
}
