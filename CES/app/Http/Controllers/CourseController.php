<?php

namespace App\Http\Controllers;

use App\DTO\EnrollmentDTO;
use App\Http\Requests\EnrollRequest;
use App\Services\CourseService;
use App\Services\EnrollmentService;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService,
        private EnrollmentService $enrollmentService
    ) {}

    public function index(): JsonResponse
    {
        $courses = $this->courseService->getAllCourses();

        return response()->json([
            'status' => 'success',
            'data' => $courses
        ]);
    }

    public function enroll(EnrollRequest $request): JsonResponse
    {
        try {
            $enrollmentDTO = EnrollmentDTO::fromRequest(
                $request->validated(), 
                auth()->id()
            );
            
            $result = $this->enrollmentService->enrollUser($enrollmentDTO);

            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'data' => $result['enrollment']
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function myCourses(): JsonResponse
    {
        $userId = auth()->id();
        $courses = $this->courseService->getUserCourses($userId);

        return response()->json([
            'status' => 'success',
            'data' => $courses
        ]);
    }
}