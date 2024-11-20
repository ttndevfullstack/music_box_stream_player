<?php

namespace App\Domain\Services;

use App\Domain\Entities\User as UserEntity;

interface IAuthenticationServiceInterface
{
    public function login(string $email, string $password);
    // public function logUserIn(UserEntity $user);
    // public function loginViaOneTimeToken(string $token);
    // public function logoutViaBearerToken(string $token): void;
    // public function trySendResetPasswordLink(string $email): bool;
    // public function trySenResetPasswordUsingBroker(string $email, string $password, string $token): bool;
    // public function generateOneTimeToken(UserEntity $user): void;
}
