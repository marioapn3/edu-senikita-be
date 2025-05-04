<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'status',
        'slug',
    ];

    public function getThumbnailAttribute($value)
    {
        if (!$value) {
            return asset('images/default-thumbnail.jpg');
        }

        return asset('storage/' . $value);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'category', 'id');
    }
}
