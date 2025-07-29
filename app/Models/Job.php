<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


class Job extends Model
{
    use HasFactory;

    // Explicitly set table name since it's not the default "jobs"
    protected $table = 'job_posts';

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'location',
        'type',
        'salary_min',
        'salary_max',
        'deadline',
        'is_active',
    ];

    /**
     * Relationship: Job belongs to a Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Scope to get only active jobs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

//     public function categories()
// {
//     return $this->belongsToMany(Category::class, 'category_job');
// }

protected $casts = [
    'deadline' => 'date',
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function savedByUsers()
{
    return $this->belongsToMany(User::class, 'saved_jobs')->withTimestamps();
}

public function savers()
{
    return $this->belongsToMany(User::class, 'saved_jobs')
                ->withPivot('filters')
                ->withTimestamps();
}

public function categories()
{
    return $this->belongsToMany(Category::class);
}

public function applicants()
{
    return $this->belongsToMany(User::class, 'applications', 'job_id', 'user_id');
}

public function applications()
{
    return $this->hasMany(JobApplication::class, 'job_id');
}

public function category()
{
    return $this->belongsTo(Category::class);
}
}
