<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SneakPeek extends Model
{
    protected $fillable = ['text', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
