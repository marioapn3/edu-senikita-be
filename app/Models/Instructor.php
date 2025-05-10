<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'expertise',
        'email',
        'phone',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function getPhotoAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}
