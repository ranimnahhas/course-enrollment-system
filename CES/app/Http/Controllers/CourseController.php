<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Course;
use App\Models\Enrollment;

class CourseController extends Controller
{
    public function index(): JsonResponse
    {
        $courses = Course::all();

        return response()->json([
            'status' => 'success',
            'data' => $courses
        ]);
    }

    public function enroll(Request $request): JsonResponse
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = auth()->user();
        $courseId = $request->course_id;

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are already enrolled in this course'
            ], 409);
        }

        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'enrolled_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully enrolled in course',
            'data' => $enrollment
        ], 201);
    }

    public function myCourses(): JsonResponse
    {
        $user = auth()->user();
        $courses = $user->courses()->withPivot('enrolled_at')->get();

        return response()->json([
            'status' => 'success',
            'data' => $courses
        ]);
    }
}