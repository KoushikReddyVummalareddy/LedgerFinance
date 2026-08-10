<?php

namespace Src\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Src\Contracts\Services\AuthServiceInterface;
use Src\Http\Requests\LoginRequest;
use Src\Http\Requests\RegisterRequest;
use Src\Models\User;

class AuthService implements AuthServiceInterface
{
    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return User
     */
    public function register(
        RegisterRequest $request
    ): User {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        Auth::login($user);

        $request->session()->regenerate();

        return $user;
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
        if (! Auth::attempt($request->only('email', 'password'))) {
            abort(401, 'Invalid credentials.');
        }

        $user = Auth::user();

        return [
            'user' => $user,
        ];
    }

    /**
     * Logout user.
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
