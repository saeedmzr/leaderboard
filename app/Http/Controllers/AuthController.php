<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Resources\SimpleResource;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Redis;
use RedisException;


class AuthController extends Controller
{
    private Redis $redisClient;

    /**
     * @throws RedisException
     */
    public function __construct(private UserRepository $userRepository)
    {
        $this->redisClient = new Redis();
        $this->redisClient->connect('localhost', 6379);
    }

    public function login(LoginRequest $loginRequest): SimpleResource|AuthResource
    {
        $user = $this->userRepository->login($loginRequest->email, $loginRequest->password);
        if (!$user) {
            return new SimpleResource(['message' => 'your credentials doesnt seems to be right.', 'status' => 422]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return new AuthResource(['access_token' => $token]);
    }

    /**
     * @throws RedisException
     */
    public function get(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->user()->id;
        $score = $this->redisClient->zScore('leaderboard', $userId);   // User's score
        $rank = $this->redisClient->zRevRank('leaderboard', $userId) + 1; // User's rank

        return response()->json([
            'user' => $request->user(),
            'score' => $score,
            'rank' => $rank,
        ]);
    }

    public function logout(): SimpleResource
    {
        auth()->user()->tokens()->delete();
        return new SimpleResource(['message' => 'you Logged out.', 'status' => 200]);
    }
}
