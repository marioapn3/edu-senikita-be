<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseRating;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseRatingService
{
    public function create($request)
    {
        $data = $request->only([
            'course_id',
            'rating',
            'review'
        ]);
        $user = $request->user();
        $user_id = $user->id;
        $data['user_id'] = $user_id;
        return CourseRating::create($data);
    }
}
