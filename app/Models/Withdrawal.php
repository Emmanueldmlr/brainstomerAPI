<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'status', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function create($request){
        $this->id = Str::uuid();
        $this->user_id = Auth::user()->id;
        $this->amount = $request->amount;
        $this->status = "COMPLETED";
        $this->save();
        return $this;
    }
}
