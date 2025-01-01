<?php

namespace App\Presentation\Http\Controllers\API;

use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Requests\UserLoginRequest;
use App\Presentation\Services\AuthenticationService;
use App\Presentation\Values\CompositeToken;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthenticationService $auth
    ) {}

    public function login(UserLoginRequest $request): JsonResponse
    {
        $compositeToken = $this->throttleLoginRequest(
            fn () => $this->auth->login($request->email, $request->password),
            $request
        );

        return responder()->success($compositeToken)->respond();
    }

    public function loginUsingOneTimeToken(Request $request): JsonResponse
    {
        $compositeToken = $this->throttleLoginRequest(
            fn () => $this->auth->loginViaOneTimeToken($request->get('token')),
            $request
        );

        return responder()->success($compositeToken)->respond();
    }

    public function logout(): JsonResponse
    {
        $this->auth->logout();

        return responder()->success()->respond();
    }

    private function throttleLoginRequest(Closure $callback, Request $request): CompositeToken
    {
        // $ip = $request->ip();
        // $attempts = cache()->get($ip, 0) + 1;
        // $maxAttempts = 5;
        // $lockoutTime = 60;

        // if ($attempts >= $maxAttempts) {
        //     cache()->put($ip, $attempts, $lockoutTime);
            // throw new TooManyRequestsException("Too many login attempts. Please try again after $lockoutTime seconds.");
        // }

        try {
            return $callback();
        } catch (Throwable) {
            // cache()->increment($ip);
            abort(Response::HTTP_UNAUTHORIZED, 'Invalid credentials');
        }
    }
}
