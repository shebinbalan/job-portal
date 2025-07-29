<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{

    protected $fillable = [
        'user_id',
        'job_id',
        'resume_path',
        'cover_letter',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function messages()
{
    return \App\Models\Message::where(function ($q) {
        $q->where('sender_id', $this->user_id)
          ->where('receiver_id', $this->job->company->user_id);
    })->orWhere(function ($q) {
        $q->where('sender_id', $this->job->company->user_id)
          ->where('receiver_id', $this->user_id);
    });
}

// public function job()
// {
//     return $this->belongsTo(Job::class, 'job_id');
// }
}
