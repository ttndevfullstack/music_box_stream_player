<?php

namespace App\Presentation\Values;

use Illuminate\Contracts\Support\Arrayable;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * A "composite token" consists of two tokens:
 *
 * - an API token, which has all abilities
 * - an audio token, which has only the "audio" ability i.e. to play and download audio files. This token is used for
 * the audio player on the frontend as part of the GET query string, and thus has limited privileges.
 *
 * This approach helps prevent the API token from being logged by servers and proxies.
 */
final class CompositeToken implements Arrayable
{
    public function __construct(
        public string $apiToken,
        public ?string $audioToken,
    ) {}

    public static function fromAccessTokens(PersonalAccessTokenResult $api, ?PersonalAccessTokenResult $audio): self
    {
        return new self($api->accessToken, $audio?->accessToken);
    }

    public function toArray(): array
    {
        return [
            'token' => $this->apiToken,
            'audio-token' => $this->audioToken,
        ];
    }
}
