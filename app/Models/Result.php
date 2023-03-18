<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['result', 'exam_id', 'reward', 'user_id', 'grading'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}