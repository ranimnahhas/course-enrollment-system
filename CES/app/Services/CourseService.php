<?php

namespace App\Services;

use App\Http\Resources\CourseResource;
use App\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Collection;

class CourseService
{
    public function __construct(
        private CourseRepository $courseRepository
    ) {}

    public function getAllCourses(): array
    {
        $courses = $this->courseRepository->getAll();
        return CourseResource::collection($courses)->resolve();
    }

    public function getUserCourses(int $userId): array
    {
        $courses = $this->courseRepository->getUserCourses($userId);
        return CourseResource::collection($courses)->resolve();
    }

    public function getCourseById(int $id): ?array
    {
        $course = $this->courseRepository->findById($id);
        return $course ? (new CourseResource($course))->resolve() : null;
    }
}