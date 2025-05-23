<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseService
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    public function getAll($request){
        $limit = $request->input('limit', 10);
        $search = $request->input('search', null);
        $category_id = $request->input('category_id', null);

        $query = Course::query();


        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($category_id) {
            $query->whereHas('categories', function ($q) use ($category_id) {
                $q->where('category_id', $category_id);
            });
        }

        $courses = $query->paginate($limit);

        // Check if token exists in request
        if ($request->bearerToken()) {
            try {
                $token = $request->bearerToken();
                $payload = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
                $user = User::find($payload->sub);
                if ($user) {
                    $enrolledCourseIds = $user->enrollments()->pluck('course_id')->toArray();

                    $courses->getCollection()->transform(function ($course) use ($enrolledCourseIds) {
                        $course->is_enrolled = in_array($course->id, $enrolledCourseIds);
                        return $course;
                    });
                }
            } catch (\Exception $e) {
                // If token is invalid, continue without enrollment info
            }
        }

        return $courses;
    }

    public function getById($id, $request )
    {
        $course = Course::with('categories')->findOrFail($id);

        if ($request->bearerToken()) {
            try {
                $token = $request->bearerToken();
                $payload = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
                $user = User::find($payload->sub);
                if ($user) {
                    $enrolledCourseIds = $user->enrollments()->pluck('course_id')->toArray();
                    $course->is_enrolled = in_array($course->id, $enrolledCourseIds);
                }
            } catch (\Exception $e) {
                // If token is invalid, continue without enrollment info
            }
        }
        return $course;
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);

        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();
        return true;
    }

    public function create($request): Course
    {
        $data = $request->only([
            'title',
            'description',
            'status',
            'level',
            'certificate_available',
            'preview_video',
            'instructor_id',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadService->upload($request->file('thumbnail'), 'course');
        }

        $slug = Str::slug($data['title']);
        if (Course::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . Str::random(5);
        }
        $data['slug'] = $slug;


       $course = Course::create($data);

       if ($request->has('categories')) {
        // dd($request->categories);
        $course->categories()->attach($request->input('categories'));
       }

       return $course;
    }

    public function getBySlug($slug , $request)
    {
        $course = Course::where('slug', $slug)->with('categories')->first();
        if ($request->bearerToken()) {
            try {
                $token = $request->bearerToken();
                $payload = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
                $user = User::find($payload->sub);
                $enrolledCourseIds = $user->enrollments()->pluck('course_id')->toArray();
                $course->is_enrolled = in_array($course->id, $enrolledCourseIds);
            } catch (\Exception $e) {
                // If token is invalid, continue without enrollment info
            }
        }
        return $course;
    }

    public function update($id, $request): Course
    {
        $course = Course::findOrFail($id);
        $data = $request->only([
            'title',
            'description',
            'thumbnail',
            'category_id',
            'status',
            'certificate_available',
            'preview_video',
            'instructor_id',
            'level',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $data['thumbnail'] = $this->uploadService->upload($request->file('thumbnail'), 'course');
        }

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
            if (Course::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $data['slug'] . '-' . Str::random(5);
            }
        }

        $course->update($data);
        return $course->fresh();
    }

}
