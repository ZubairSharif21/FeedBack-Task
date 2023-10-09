<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
        public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function rating()
    {
        return $this->hasMany(Review::class);
    }

    public function vote()
    {
        return $this->hasMany(Vote::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
