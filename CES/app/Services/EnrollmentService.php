<?php

namespace App\Services;

use App\DTO\EnrollmentDTO;
use App\Repositories\EnrollmentRepository;

class EnrollmentService
{
    public function __construct(
        private EnrollmentRepository $enrollmentRepository
    ) {}

    public function enrollUser(EnrollmentDTO $enrollmentDTO): array
    {
        if ($this->enrollmentRepository->userEnrolledInCourse(
            $enrollmentDTO->userId, 
            $enrollmentDTO->courseId
        )) {
            throw new \Exception('User already enrolled in this course', 409);
        }

        $enrollment = $this->enrollmentRepository->create([
            'user_id' => $enrollmentDTO->userId,
            'course_id' => $enrollmentDTO->courseId,
            'enrolled_at' => now(),
        ]);

        return [
            'enrollment' => $enrollment,
            'message' => 'Successfully enrolled in course'
        ];
    }

    public function getUserEnrollments(int $userId)
    {
        return $this->enrollmentRepository->getUserEnrollments($userId);
    }
}