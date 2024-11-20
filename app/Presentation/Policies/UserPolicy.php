<?php

namespace App\Presentation\Policies;

use App\Presentation\Models\User;

class UserPolicy
{
    public function admin(User $currentUser): bool
    {
        return $currentUser->is_admin;
    }

    public function destroy(User $currentUser, User $userToDestroy): bool
    {
        return $currentUser->is_admin && $currentUser->isNot($userToDestroy);
    }
}
