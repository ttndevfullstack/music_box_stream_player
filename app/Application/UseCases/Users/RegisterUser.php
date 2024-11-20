<?php

namespace App\Application\UseCases\Users;

use App\Domain\Entities\User as UserEntity;
use App\Application\DTOs\UserDTO;
use App\Domain\Repositories\IUserRepositoryInterface;

class RegisterUser
{
    public function __construct(private readonly IUserRepositoryInterface $userRepository) {}

    public function execute(UserDTO $userDTO)
    {
        $hashedPassword  = bcrypt($userDTO->password);
        $newUser  = new UserEntity(
            null,
            $userDTO->name,
            $userDTO->email,
            $hashedPassword,
            $userDTO->is_admin,
            now(),
        );

        return $this->userRepository->create($newUser);
    }
}
