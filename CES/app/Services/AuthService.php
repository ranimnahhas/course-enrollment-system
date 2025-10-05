<?php

namespace App\Services;

use App\DTO\AuthDTO;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function register(AuthDTO $authDTO): array
    {
        $user = $this->userRepository->create([
            'name' => $authDTO->name,
            'email' => $authDTO->email,
            'password' => Hash::make($authDTO->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'user' => new UserResource($user),
            'token' => $token
        ];
    }

    public function login(array $credentials): ?array
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            return null;
        }

        $user = auth()->user();

        return [
            'token' => $token,
            'user' => new UserResource($user)
        ];
    }

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function getCurrentUser()
    {
        $user = auth()->user();
        return $user ? new UserResource($user) : null;
    }
}