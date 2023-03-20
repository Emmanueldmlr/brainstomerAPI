<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['result', 'exam_id', 'reward', 'user_id', 'grading'];
    protected $keyType = 'string';

    protected $with = ['exams'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exams()
    {
        return $this->belongsTo(Exam::class);
    }

    public function create($score, $grading, $exam_id, $reward){
        $this->result = $score;
        $this->grading = $grading;
        $this->exam_id = $exam_id;
        $this->reward = $reward;
        $this->user_id = Auth::user()->id;
        $this->id = Str::uuid();
        $this->save();
        return $this;
    }
}
