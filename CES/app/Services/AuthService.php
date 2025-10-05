<?php

namespace App\Services;

use App\DTO\AuthDTO;
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
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(array $credentials): ?array
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            return null;
        }

        return [
            'token' => $token,
            'user' => auth()->user()
        ];
    }

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function getCurrentUser()
    {
        return auth()->user();
    }
}