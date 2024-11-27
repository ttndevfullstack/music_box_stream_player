<?php

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