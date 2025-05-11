<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'level',
        'duration',
        'status',
        'certificate_available',
        'preview_video',
        'thumbnail',
        'instructor_id',
        'slug'
    ];

    public function getThumbnailAttribute($value)
    {
        if (!$value) {
            return asset('images/default-thumbnail.jpg');
        }

        return asset('storage/' . $value);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_course');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
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

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function additionalMaterials(): HasMany
    {
        return $this->hasMany(AdditionalMaterial::class);
    }
}
