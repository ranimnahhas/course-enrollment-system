<?php

namespace App\Http\Controllers;

use App\DTO\AuthDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $authDTO = AuthDTO::fromRequest($request->validated());
        
        $result = $this->authService->register($authDTO);

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => $result
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        
        $result = $this->authService->login($credentials);

        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => $result
        ]);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ]);
    }

    public function me(): JsonResponse
    {
        $user = $this->authService->getCurrentUser();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
}