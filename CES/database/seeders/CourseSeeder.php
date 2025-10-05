<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $courses = [
            [
                'title' => 'Introduction to Laravel',
                'description' => 'Learn the fundamentals of Laravel framework',
                'instructor' => 'John Doe',
                'duration' => 30,
                'price' => 99.99
            ],
            [
                'title' => 'Advanced PHP Programming',
                'description' => 'Deep dive into advanced PHP concepts',
                'instructor' => 'Jane Smith',
                'duration' => 45,
                'price' => 149.99
            ],
            [
                'title' => 'Vue.js for Beginners',
                'description' => 'Build modern web applications with Vue.js',
                'instructor' => 'Mike Johnson',
                'duration' => 25,
                'price' => 79.99
            ],
            [
                'title' => 'Database Design Fundamentals',
                'description' => 'Learn how to design efficient databases',
                'instructor' => 'Sarah Wilson',
                'duration' => 35,
                'price' => 119.99
            ],
            [
                'title' => 'RESTful API Development',
                'description' => 'Create robust REST APIs with best practices',
                'instructor' => 'David Brown',
                'duration' => 40,
                'price' => 129.99
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}