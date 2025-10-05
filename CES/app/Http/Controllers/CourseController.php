<?php

namespace App\Http\Controllers;

use App\DTO\EnrollmentDTO;
use App\Http\Requests\EnrollRequest;
use App\Services\CourseService;
use App\Services\EnrollmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService,
        private EnrollmentService $enrollmentService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $courses = $this->courseService->getAllCourses();
            return $this->success(['courses' => $courses]);
        } catch (\Exception $e) {
            return $this->error('Failed to fetch courses', 500);
        }
    }

    public function enroll(EnrollRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $enrollmentDTO = EnrollmentDTO::fromRequest($request->validated(), $user->id);
            
            $result = $this->enrollmentService->enrollUser($enrollmentDTO);
            
            return $this->success($result, 'Successfully enrolled in course', 201);
        } catch (\Exception $e) {
            $code = $e->getCode() ?: 500;
            return $this->error($e->getMessage(), $code);
        }
    }

    public function myCourses(): JsonResponse
    {
        try {
            $user = auth()->user();
            $courses = $this->courseService->getUserCourses($user->id);
            
            return $this->success(['courses' => $courses]);
        } catch (\Exception $e) {
            return $this->error('Failed to fetch user courses', 500);
        }
    }

    public function myEnrollments(): JsonResponse
    {
        try {
            $user = auth()->user();
            $enrollments = $this->enrollmentService->getUserEnrollments($user->id);
            
            return $this->success(['enrollments' => $enrollments]);
        } catch (\Exception $e) {
            return $this->error('Failed to fetch enrollments', 500);
        }
    }
}