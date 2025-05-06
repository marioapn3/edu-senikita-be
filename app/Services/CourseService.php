<?php

namespace App\Services;

use App\Models\Course;
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

        $query->where('status', 'published');

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        return $query->paginate($limit);
    }

    public function getById($id)
    {
        return Course::findOrFail($id)->with('instructor')->first();
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
            'category_id',
            'status',
            'level',
            'duration',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadService->upload($request->file('thumbnail'), 'course');
        }

        $slug = Str::slug($data['title']);
        if (Course::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . Str::random(5);
        }
        $data['slug'] = $slug;

        return Course::create($data);
    }

    public function getBySlug($slug = null)
    {
        return Course::where('slug', $slug)->with('instructor')->first();
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
            'certificate_available'
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
        return $course->update($data);
    }
}
