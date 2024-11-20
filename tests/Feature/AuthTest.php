<?php

namespace Tests\Feature;

use App\Presentation\Models\User;
use App\Presentation\Services\AuthenticationService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

use function Tests\create_user;

class AuthTest extends TestCase
{
    // use DatabaseMigrations;
    use DatabaseTransactions;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = create_user([
            'email' => 'musicbox@gmail.devz',
            'password' => 'secret',
        ]);
    }

    public function test_login_success(): void
    {
        $body = [
            'email' => $this->user->email,
            'password' => 'secret'
        ];

        $response = $this->post('api/me', $body)
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'success',
                'data' => [
                    'token',
                ],
            ]);

        self::assertNotEmpty($response->json('data.token'));
    }

    public function test_login_via_one_time_token_success(): void
    {
        $user = create_user();
        $authService = app(AuthenticationService::class);
        $oneTimeToken = $authService->generateOneTimeToken($user);

        $body = ['token' => $oneTimeToken];

        $response = $this->post('api/me/otp', $body)
            ->assertOK()
            ->assertJsonStructure([
                'status',
                'success',
                'data' => [
                    'token',
                ],
            ]);

        self::assertNotEmpty($response->json('data.token'));
    }

    public function test_login_failure(): void
    {
        $body = [
            'email' => $this->user->email,
            'password' => 'wrong-secret'
        ];

        $this->post('api/me', $body)
            ->assertUnauthorized();
    }

    public function test_logout_success(): void
    {
        $user = create_user([
            'email' => 'logout@gmail.dev',
            'password' => 'secret',
        ]);

        $body = [
            'email' => $user->email,
            'password' => 'secret'
        ];

        $response = $this->post('api/me', $body)
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'success',
                'data' => [
                    'token',
                ],
            ]);

        $token = $response->json('data.token');
        self::assertNotEmpty($token);

        $this->withToken($token)
            ->delete('api/me')
            ->assertOk()
            ->assertJson([
                'status' => 200,
                'success' => true,
            ]);
    }
}
