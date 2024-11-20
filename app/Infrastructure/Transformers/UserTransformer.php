<?php

namespace App\Infrastructure\Transformers;

use App\Domain\Entities\User as UserEntity;
use App\Presentation\Models\User as UserModel;

class UserTransformer
{
    /**
     * Convert a domain entity to a presentation model.
     */
    public static function entityToModel(UserEntity $userEntity): UserModel
    {
        return new UserModel([
            'id' => $userEntity->id,
            'name' => $userEntity->name,
            'email' => $userEntity->email,
            'password' => $userEntity->password,
            'is_admin' => $userEntity->isAdmin,
            'created_at' => $userEntity->created_at,
        ]);
    }

    /**
     * Convert a presentation model to a domain entity.
     */
    public static function modelToEntity(UserModel $userModel): UserEntity
    {
        return new UserEntity(
            $userModel->id,
            $userModel->name,
            $userModel->email,
            $userModel->password,
            $userModel->is_admin,
            $userModel->created_at,
        );
    }
}
