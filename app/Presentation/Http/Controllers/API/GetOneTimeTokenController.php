<?php

namespace App\Presentation\Http\Controllers\API;

use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Services\AuthenticationService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

class GetOneTimeTokenController extends Controller
{
    public function __invoke(AuthenticationService $auth, Authenticatable $user): JsonResponse
    {
        return responder()->success([
            'token' => $auth->generateOneTimeToken($user),
        ])->respond();
    }
}
