<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobAlert extends Model
{
    protected $fillable = ['user_id', 'keyword', 'location', 'industry', 'type', 'enabled'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
