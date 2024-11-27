<?php

namespace App\Presentation\Resources;

use App\Presentation\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public const JSON_STRUCTURE = [
        'type',
        'id',
        'name',
        'email',
        'password',
        'is_admin',
    ];

    public function __construct(private readonly User $user)
    {
        parent::__construct($user);
    }

    /** @return array<mixed> */
    public function toArray($request): array
    {
        return [
            'type' => 'users',
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password' => $this->user->password,
            'is_admin' => $this->user->is_admin,
        ];
    }
}
