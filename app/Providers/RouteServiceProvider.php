<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Webmozart\Assert\Assert;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            self::loadBaseAwareRoutes(['web', 'api']);
            self::loadVersionAwareRoutes('web');
            self::loadVersionAwareRoutes('api');
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(3)->by($request->user()?->id ?: $request->ip());
        });
    }

    private static function loadBaseAwareRoutes(array|string $types): void
    {
        $types =  !is_array($types) ? [$types] : $types;

        foreach ($types as $type) {
            Route::middleware($type)
                ->prefix($type === 'api' ? 'api' : null)
                ->group(base_path(sprintf('routes/%s.base.php', $type)));
        }
    }

    private static function loadVersionAwareRoutes(string $type): void
    {
        Assert::oneOf($type, config('app.api_supported.types'));
        
        $apiVersion = self::getApiVersion();
        $routeFile = $apiVersion ? base_path(sprintf('routes/api/%s/%s.php', $apiVersion, $type)) : null;

        if ($routeFile && File::exists($routeFile)) {
            Route::middleware('api')
                ->prefix(sprintf('api/%s', $apiVersion))
                // ->namespace(sprintf(controller_namespace().ucfirst($apiVersion)))
                ->group([], $routeFile);
        }
    }

    private static function getApiVersion(): ?string
    {
        $version = app()->runningUnitTests() ? env('X_API_VERSION') : strtolower(request()->header('X-Api-Version'));

        if ($version) {
            Assert::oneOf($version, config('app.api_supported.versions'));
        }

        return $version;
    }
}
