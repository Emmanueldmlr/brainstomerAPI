<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'user_id', 'start_time', 'end_time', 'duration', 'category', 'is_completed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
