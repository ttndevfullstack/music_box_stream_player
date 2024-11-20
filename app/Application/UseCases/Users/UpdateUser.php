<?php

namespace App\Application\UseCases\Users;

use App\Domain\Repositories\IUserRepositoryInterface;

class UpdateUser
{
    public function __construct(private readonly IUserRepositoryInterface $userRepository) {}

    public function execute($id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }
}
   