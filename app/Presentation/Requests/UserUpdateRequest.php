<?php

namespace App\Presentation\Requests;

use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends Request
{
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['sometimes', Password::defaults()],
            'is_admin' => 'sometimes',
        ];
    }
}
