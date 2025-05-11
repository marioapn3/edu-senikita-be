<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdditionalMaterial extends Model
{
    protected $fillable = ['title', 'file_path', 'course_id'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getFilePathAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
