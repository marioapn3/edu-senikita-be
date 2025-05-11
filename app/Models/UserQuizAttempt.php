<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserQuizAttempt extends Model
{
    protected $table = 'user_quiz_attempts';
    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'is_passed',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'score' => 'integer',
        'is_passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(UserQuizAnswer::class);
    }
}
