<?php

namespace App\Presentation\Services;

use App\Domain\Services\IAuthenticationServiceInterface;
use App\Infrastructure\Repositories\UserRepository;
use App\Presentation\Exceptions\InvalidCredentialsException;
use App\Presentation\Models\User;
use App\Presentation\Values\CompositeToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthenticationService implements IAuthenticationServiceInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TokenManager $tokenManager,
    ) {}

    public function login(string $email, string $password): CompositeToken
    {
        $user = $this->userRepository->findOneByEmail($email);
        if (!$user || !Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        if (Hash::needsRehash($user->password)) {
            $user->password = Hash::make($password);
            $user->save();
        }

        return $this->logUserIn($user);
    }

    public function logUserIn(User $user): CompositeToken
    {
        return $this->tokenManager->createCompositeToken($user);
    }

    public function logout(): void
    {
        auth()->user()->token()->revoke();
    }

    public function loginViaOneTimeToken(string $token): CompositeToken
    {
        return $this->logUserIn($this->userRepository->getOne(decrypt(Cache::get("one-time-token.$token"))));
    }

    // public function logoutViaBearerToken(string $token): void
    // {
    //     // Todo
    // }

    // public function trySendResetPasswordLink(string $email): bool
    // {
    //     // Todo
    // }

    // public function trySenResetPasswordUsingBroker(string $email, string $password, string $token): bool
    // {
    //     // Todo
    // }

    public function generateOneTimeToken(User $user): string
    {
        $token = bin2hex(random_bytes(12));
        Cache::set("one-time-token.$token", encrypt($user->id), 60 * 10);

        return $token;
    }
}
