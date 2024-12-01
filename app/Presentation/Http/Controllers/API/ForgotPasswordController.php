<?php

namespace App\Presentation\Http\Controllers\API;

use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Requests\ForgotPasswordRequest;
use App\Presentation\Services\AuthenticationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request, AuthenticationService $auth): JsonResponse
    {
        static::disableInDemo();

        return $auth->trySendResetPasswordLink($request->email)
            ? responder()->success()->respond()
            : responder()->error(Response::HTTP_NOT_FOUND)->respond();
    }
}
