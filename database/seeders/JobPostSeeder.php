<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Company;
use Carbon\Carbon;

class JobPostSeeder extends Seeder
{
    public function run(): void
    {
        // Create a sample company (if needed)
        $company = Company::first() ?? Company::factory()->create([
            'name' => 'TechNova Ltd.',
        ]);

        // Insert sample job posts
        Job::insert([
            [
                'company_id' => $company->id,
                'title' => 'Full Stack Developer',
                'description' => 'Develop web applications using Laravel and Vue.js.',
                'location' => 'Remote',
                'type' => 'full-time',
                'salary_min' => 50000,
                'salary_max' => 70000,
                'deadline' => Carbon::now()->addDays(10),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => $company->id,
                'title' => 'UI/UX Designer',
                'description' => 'Design intuitive interfaces and user experiences.',
                'location' => 'New York',
                'type' => 'part-time',
                'salary_min' => 30000,
                'salary_max' => 50000,
                'deadline' => Carbon::now()->addDays(15),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
