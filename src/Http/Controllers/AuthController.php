<?php

namespace Src\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Contracts\Services\AuthServiceInterface;
use Src\Http\Requests\LoginRequest;
use Src\Http\Requests\RegisterRequest;
use Src\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return UserResource
     */
    public function register(
        RegisterRequest $request
    ): UserResource {
        $record = $this->authService
            ->register($request);

        return new UserResource($record);
    }

    /**
     * Login user.
     *
     * @param LoginRequest $request
     * @return array
     */
    public function login(
        LoginRequest $request
    ): array {
        return $this->authService
            ->login($request);
    }

    /**
     * Logout user.
     *
     * @return array
     */
    public function logout(): array
    {
        $this->authService->logout();

        return [
            'message' => 'Logged out successfully.'
        ];
    }
}