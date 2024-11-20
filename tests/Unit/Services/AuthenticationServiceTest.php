<?php

namespace Tests\Unit\Services;

use App\Infrastructure\Repositories\UserRepository;
use App\Presentation\Services\AuthenticationService;
use App\Presentation\Services\TokenManager;
use Illuminate\Auth\Passwords\PasswordBroker;
use Mockery\MockInterface;
use Tests\TestCase;

class AuthenticationServiceTest extends TestCase
{
    private UserRepository|MockInterface $userRepository;
    private TokenManager|MockInterface $tokenManager;
    private PasswordBroker|MockInterface $passwordBroker;
    private AuthenticationService $authService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->tokenManager = Mockery::mock(TokenManager::class);
        // $this->passwordBroker = Mockery::mock(PasswordBroker::class);

        $this->authService = new AuthenticationService(
            $this->userRepository,
            $this->tokenManager,
            // $this->passwordBroker
        );
    }
}
