<?php

namespace App\Presentation\Http\Controllers\API;

use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Resources\UserResource;
use Illuminate\Contracts\Auth\Authenticatable;

class FetchInitialDataController extends Controller
{
    public function __invoke(
        ?Authenticatable $user
    ) {
        return responder()->success(
            [
                'current_user' => UserResource::make($user)
            ]
        )->respond();
    }
}
