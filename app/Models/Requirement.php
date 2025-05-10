<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $fillable = ['text', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
