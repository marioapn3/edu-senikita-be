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
        $status = $request->input('status', null);
        $user = $request->user();

        if ($status && !in_array($status, ['enrolled', 'on going', 'completed'])) {
            throw new Exception('Invalid status. Status must be one of: enrolled, on going, completed');
        }

        $query = Enrollment::with(['course', 'course.lessons']);

        if ($search) {
            $query->whereHas('course', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if($user){
            if($user->role == 'user'){
                $query->where('user_id', $user->id);
            }
        }

        $enrollments = $query->paginate($limit);

        // Add completion statistics for each enrollment
        $enrollments->getCollection()->transform(function ($enrollment) use ($user) {
            $totalLessons = $enrollment->course->lessons->count();
            $completedLessons = $enrollment->course->lessons->filter(function ($lesson) use ($user) {
                return $lesson->users->contains('id', $user->id) &&
                       $lesson->users->firstWhere('id', $user->id)->pivot->is_completed;
            })->count();

            $enrollment->completion_stats = [
                'total_lessons' => $totalLessons,
                'completed_lessons' => $completedLessons,
                'completion_percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 2) : 0
            ];

            return $enrollment;
        });

        return $enrollments;
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
    public function getTotalCourse($request){
        $user = $request->user();
        $enrollments = Enrollment::where('user_id', $user->id)->get();
        $total_course = $enrollments->count();
        $total_course_completed = $enrollments->where('status', 'completed')->count();
        $total_course_on_going = $enrollments->where('status', 'on going')->count();
        return [
            'total_course' => $total_course,
            'total_course_completed' => $total_course_completed,
            'total_course_on_going' => $total_course_on_going
        ];
    }

}
