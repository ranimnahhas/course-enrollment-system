<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseRepository
{
    public function getAll(): Collection
    {
        return Course::all();
    }

    public function findById(int $id): ?Course
    {
        return Course::find($id);
    }

    public function getUserCourses(int $userId): Collection
    {
        return Course::whereHas('enrollments', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }

    public function create(array $data): Course
    {
        return Course::create($data);
    }

    public function update(Course $course, array $data): bool
    {
        return $course->update($data);
    }

    public function delete(Course $course): bool
    {
        return $course->delete();
    }
}