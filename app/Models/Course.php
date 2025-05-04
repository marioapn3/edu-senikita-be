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
        'category',
        'slug',
        'status',
    ];

    public function getThumbnailAttribute($value)
    {
        if (!$value) {
            return asset('images/default-thumbnail.jpg');
        }

        return asset('storage/' . $value);
    }

}
