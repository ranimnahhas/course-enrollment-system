<?php

namespace App\Repositories;

use App\Models\Enrollment;

class EnrollmentRepository
{
    public function create(array $data): Enrollment
    {
        return Enrollment::create($data);
    }

    public function userEnrolledInCourse(int $userId, int $courseId): bool
    {
        return Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    }

    public function getUserEnrollments(int $userId)
    {
        return Enrollment::with('course')
            ->where('user_id', $userId)
            ->get();
    }
}