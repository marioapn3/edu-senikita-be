<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_id',
        'order',
        'title',
        'slug',
        'type',
        'description',
        'content',
        'video_url',
        'duration',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


}
