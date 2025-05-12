<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonUser extends Model
{
    protected $fillable = [
        'lesson_id',
        'user_id',
        'is_completed',
        'completed_at',
    ];

    protected $table = 'lesson_user';

}
