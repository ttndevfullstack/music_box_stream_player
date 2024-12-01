<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Presentation\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->configureTokenExpirations();
        $this->configurePasswordDefaultRules();
        $this->configureResetPasswordLink();
    }

    private function configureTokenExpirations(): void
    {
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }

    private function configurePasswordDefaultRules(): void
    {
        Password::defaults(fn() => $this->app->isProduction()
            ? Password::min(10)->letters()->numbers()->symbols()->uncompromised()
            : Password::min(6)
        );
    }

    private function configureResetPasswordLink(): void
    {
        ResetPassword::createUrlUsing(static function (User $user, string $token) {
            $payload = base64_encode($user->getEmailForPasswordReset()."|$token");
            
            return url("/#/reset-password/$payload");
        });
    }
}
