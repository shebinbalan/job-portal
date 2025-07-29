<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Job;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class JobRecommendationSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        $user = User::firstOrCreate([
            'email' => 'seeker@example.com',
        ], [
            'name' => 'Test Seeker',
            'password' => bcrypt('password'),
        ]);

        // Create categories
        $categories = Category::factory()->count(3)->sequence(
            ['name' => 'Engineering'],
            ['name' => 'Design'],
            ['name' => 'Marketing']
        )->create();

        // Create jobs
        $jobs = Job::factory()->count(6)->sequence(
            ['title' => 'Frontend Developer'],
            ['title' => 'Backend Developer'],
            ['title' => 'UI Designer'],
            ['title' => 'UX Researcher'],
            ['title' => 'Marketing Specialist'],
            ['title' => 'Content Writer']
        )->create();

        // Map jobs to categories (pivot table)
        $mapping = [
            1 => 1, // Job 1 => Category 1 (Engineering)
            2 => 1,
            3 => 2, // Job 3 => Category 2 (Design)
            4 => 2,
            5 => 3, // Job 5 => Category 3 (Marketing)
            6 => 3,
        ];

        foreach ($mapping as $jobId => $categoryId) {
            DB::table('category_job')->insert([
                'job_id' => $jobId,
                'category_id' => $categoryId,
            ]);
        }

        // Simulate saved jobs (user interacted)
        $user->savedJobs()->syncWithoutDetaching([1, 3]); // Saved Job 1 and 3

        // Simulate applied jobs
        $user->applications()->createMany([
            ['job_id' => 2],
            ['job_id' => 4],
        ]);
    }
}
