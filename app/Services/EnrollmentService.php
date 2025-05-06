<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Course;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EnrollmentService
{
    public function getAll($request)
    {
        $limit = $request->input('limit', 10);
        $search = $request->input('search', null);
        $user = $request->user();

        $query = Enrollment::with('course');

        if ($search) {
            $query->whereHas('course', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        if($user){
            if($user->role == 'user'){
                $query->where('user_id', $user->id);
            }
        }

        return $query->paginate($limit);
    }

    public function getById($id)
    {
        return Enrollment::findOrFail($id);
    }
    public function getBySlug($slug)
    {
        return Enrollment::where('slug', $slug)->firstOrFail();
    }
    public function delete($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();
        return true;
    }

    public function store($request)
    {
        $user = $request->user();
        $course_id = $request->course_id;
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course_id)
            ->first();
        if ($enrollment) {
            throw new Exception('You are already enrolled in this course');
        }
        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course_id,
            'status' => 'enrolled',
        ]);

        return $enrollment;
    }

}
