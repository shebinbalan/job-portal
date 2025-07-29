<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'website',
        'logo',
        'description',
        'industry',
        'founded_year',
        'location',
        'contact_email',
        'phone',
        'linkedin',
        'size',
        'verified',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
