<?php

use Illuminate\Support\Facades\Vite;

/**
 * Get a URL for static file requests.
 * If this installation MusicBox has a CDN_URL configured, use it as the base.
 * Otherwise, just use a full URL to the asset.
 *
 * @param string|null $name The optional resource name/path
 */
function static_url(?string $name = null): string
{
    $cdnUrl = trim(config('koel.cdn.url'), '/ ');

    return $cdnUrl ? $cdnUrl . '/' . trim(ltrim($name, '/')) : trim(asset($name));
}

function controller_namespace(): string
{
    return 'App\Presentation\Http\Controllers';
}

/**
 * A quick check to determine if a mailer is configured.
 * This is not bulletproof but should work in most cases.
 */
function mailer_configured(): bool
{
    return config('mail.default') && !in_array(config('mail.default'), ['log', 'array'], true);
}