<?php

namespace Tests;

use App\Presentation\Models\User;
use Illuminate\Support\Facades\Hash;

function create_user(array $attributes = []): User
{
    if (isset($attributes['password'])) {
        $attributes['password'] = Hash::make($attributes['password']);
    }
    
    return User::factory()->create($attributes);
}
