<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
   protected $fillable = ['seeker_id', 'title', 'file_path'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function seeker()
{
    return $this->belongsTo(User::class, 'seeker_id');
}
public function user()
{
    return $this->belongsTo(User::class, 'seeker_id');
}
}
