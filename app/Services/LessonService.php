<?php

namespace App\Services;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LessonService
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    public function getAll($request)
    {
        $limit = $request->input('limit', 10);
        $search = $request->input('search', null);

        $query = Lesson::query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        return $query->paginate($limit);
    }

    public function getById($id)
    {
        return Lesson::findOrFail($id);
    }
    public function getBySlug($slug)
    {
        return Lesson::where('slug', $slug)->firstOrFail();
    }
    public function delete($id)
    {
        $category = Lesson::findOrFail($id);

        if ($category->thumbnail) {
            Storage::disk('public')->delete($category->thumbnail);
        }

        $category->delete();
        return true;
    }

    public function create($request)
    {
        $data = $request->only([
            'course_id',
            'order',
            'title',
            'type',
            'description',
            'content',
            'video_url',
        ]);

        $slug = Str::slug($data['title']);
        if(Lesson::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . Str::random(5);
        }
        $data['slug'] = $slug;

        $category = Lesson::create($data);
        return $category;
    }

    public function update($id, $request)
    {
        $category = Lesson::findOrFail($id);

        $data = $request->only([
            'course_id',
            'order',
            'title',
            'type',
            'description',
            'content',
            'video_url',
        ]);


        $category->update($data);
        return $category;
    }
}
