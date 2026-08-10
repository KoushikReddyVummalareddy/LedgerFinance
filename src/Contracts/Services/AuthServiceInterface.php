<?php

namespace Src\Contracts\Services;

use Src\Http\Requests\LoginRequest;
use Src\Http\Requests\RegisterRequest;
use Src\Models\User;

interface AuthServiceInterface
{
    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return User
     */
    public function register(
        RegisterRequest $request
    ): User;

    /**
     * Login user.
     *
     * @param LoginRequest $request
     * @return array
     */
    public function login(
        LoginRequest $request
    ): array;

    /**
     * Logout authenticated user.
     *
     * @return void
     */
    public function logout(): void;
}