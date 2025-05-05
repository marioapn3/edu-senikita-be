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
        'category_id',
        'slug',
        'status',
        'duration',
        'level',
        'instructor_id',
    ];

    public function getThumbnailAttribute($value)
    {
        if (!$value) {
            return asset('images/default-thumbnail.jpg');
        }

        return asset('storage/' . $value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function instructor(){
        return $this->belongsTo(Instructor::class, 'instructor_id', 'id');
    }

}
