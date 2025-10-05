<?php

namespace App\Services;

use App\Repositories\CourseRepository;

class CourseService
{
    public function __construct(
        private CourseRepository $courseRepository
    ) {}

    public function getAllCourses()
    {
        return $this->courseRepository->getAll();
    }

    public function getUserCourses(int $userId)
    {
        return $this->courseRepository->getUserCourses($userId);
    }
}