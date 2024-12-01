<?php

namespace App\Presentation\Http\Controllers\API;

use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Requests\ResetPasswordRequest;
use App\Presentation\Services\AuthenticationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request, AuthenticationService $auth): JsonResponse
    {
        static::disableInDemo();

        return $auth->tryResetPasswordUsingBroker($request->email, $request->password, $request->token)
            ? responder()->success()->respond()
            : responder()->error(Response::HTTP_UNPROCESSABLE_ENTITY)->respond();
    }
}
