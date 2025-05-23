<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinalSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'lesson_id',
        'submission',
        'file_path',
        'status',
        'feedback',
        'score',
        'is_published',
        'type',
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function getFilePathAttribute()
    {
        return isset($this->attributes['file_path'])
            ? asset('storage/' . $this->attributes['file_path'])
            : null;
    }

}
