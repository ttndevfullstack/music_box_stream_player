<?php

namespace App\Presentation\Services;

use App\Presentation\Models\User;
use App\Presentation\Values\CompositeToken;
use Illuminate\Support\Facades\Cache;
use Laravel\Passport\PersonalAccessTokenResult;

class TokenManager
{
    public function createToken(User $user, array $scopes = ['*']): PersonalAccessTokenResult
    {
        return $user->createToken(config('app.name'), $scopes);
    }

    public function createCompositeToken(User $user): CompositeToken
    {
        $compositeToken = CompositeToken::fromAccessTokens(
            api: $this->createToken($user),
            // audio: $this->createToken($user, ['audio'])
        );

        // Cache::forever("app.composite-tokens.$compositeToken->apiToken", $compositeToken->audioToken);

        return $compositeToken;
    }

    public function deleteCompositionToken(string $plainTextApiToken): void
    {
        /** @var string $audioToken */
        $audioToken = Cache::get("app.composite-tokens.$plainTextApiToken");
        
        if ($audioToken) {
            self::deleteTokenByPlainTextToken($audioToken);
            Cache::forget("app.composite-tokens.$plainTextApiToken");
        }

        self::deleteTokenByPlainTextToken($plainTextApiToken);
    }

    public function deleteTokenByPlainTextToken(string $plainTextToken): void
    {
        PersonalAccessToken::findToken($plainTextToken)?->delete();                
    }

    public function destroyTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}
