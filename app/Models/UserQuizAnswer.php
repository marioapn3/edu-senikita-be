<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuizAnswer extends Model
{
    protected $fillable = [
        'user_quiz_attempt_id',
        'quiz_question_id',
        'quiz_answer_id',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(UserQuizAttempt::class, 'user_quiz_attempt_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(QuizAnswer::class, 'quiz_answer_id');
    }
}
