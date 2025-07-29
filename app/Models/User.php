<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'resume_template',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function isEmployer(): bool
{
    return $this->role === 'employer';
}

public function isSeeker(): bool
{
    return $this->role === 'seeker';
}
public function bookmarkedSeekers()
{
    return $this->belongsToMany(User::class, 'bookmarks', 'employer_id', 'seeker_id')->withTimestamps();
}

// For seekers
public function bookmarkedByEmployers()
{
    return $this->belongsToMany(User::class, 'bookmarks', 'seeker_id', 'employer_id')->withTimestamps();
}



public function certificates()
{
    return $this->hasMany(Certificate::class, 'seeker_id');
}

public function savedJobs()
{
    return $this->belongsToMany(Job::class, 'saved_jobs')
        ->withPivot('filters')
        ->withTimestamps();
}


public function applications()
{
    return $this->hasMany(JobApplication::class);
}

public function appliedJobs()
{
    return $this->belongsToMany(Job::class, 'applications', 'user_id', 'job_id');
}

public function saveJobs()
{
    return $this->belongsToMany(\App\Models\Job::class, 'job_user_saves')->withTimestamps();
}





}
