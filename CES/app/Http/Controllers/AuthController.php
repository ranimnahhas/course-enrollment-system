<?php

namespace App\Http\Controllers;

use App\DTO\AuthDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $authDTO = AuthDTO::fromRequest($request->validated());
            $result = $this->authService->register($authDTO);

            return $this->success($result, 'User registered successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Registration failed: ' . $e->getMessage(), 500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validated();
            $result = $this->authService->login($credentials);

            if (!$result) {
                return $this->error('Invalid credentials', 401);
            }

            return $this->success($result, 'Login successful');
        } catch (\Exception $e) {
            return $this->error('Login failed: ' . $e->getMessage(), 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout();
            return $this->success(null, 'Successfully logged out');
        } catch (\Exception $e) {
            return $this->error('Logout failed: ' . $e->getMessage(), 500);
        }
    }

    public function me(): JsonResponse
    {
        try {
            $user = $this->authService->getCurrentUser();
            return $this->success(['user' => $user]);
        } catch (\Exception $e) {
            return $this->error('Failed to get user data', 500);
        }
    }
}