<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'user_id', 'start_time', 'end_time', 'duration', 'is_completed'];

    protected $casts = [
        'question' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function results(){
        return $this->hasMany(Result::class);
    }

    public function create($question){
        $this->question = $question;
        $this->user_id = Auth::user()->id;
        $this->id = Str::uuid();
        $this->save();
        return $this;
    }
}
