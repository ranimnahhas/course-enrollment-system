<?php

namespace App\DTO;

class EnrollmentDTO
{
    public function __construct(
        public int $userId,
        public int $courseId
    ) {}

    public static function fromRequest(array $data, int $userId): self
    {
        return new self(
            userId: $userId,
            courseId: $data['course_id']
        );
    }
}