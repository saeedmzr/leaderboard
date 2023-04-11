<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\SimpleResource;
use App\Repositories\User\UserRepository;


class AuthController extends Controller
{

    public function __construct(private UserRepository $userRepository)
    {
    }

    public function login(LoginRequest $loginRequest): SimpleResource|AuthResource
    {
        $user = $this->userRepository->login($loginRequest->email, $loginRequest->password);
        if (!$user) return new SimpleResource(['message' => 'your credentials doesnt seems to be right.', 'status' => 422]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return new AuthResource(['access_token' => $token]);
    }

    public function get(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function logout(): SimpleResource
    {
        auth()->user()->tokens()->delete();
        return new SimpleResource(['message' => 'you Logged out.', 'status' => 200]);
    }
}
