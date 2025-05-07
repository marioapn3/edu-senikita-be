<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'certificate_available',
        'thumbnail',
        'slug',
        'status',
        'level',
        'instructor_id',
        'preview_video',
    ];

    public function getThumbnailAttribute($value)
    {
        if (!$value) {
            return asset('images/default-thumbnail.jpg');
        }

        return asset('storage/' . $value);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }


    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id', 'id');
    }

    public function sneakpeeks()
    {
        return $this->hasMany(SneakPeek::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    public function ratings()
    {
        return $this->hasMany(CourseRating::class);
    }

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }

}
