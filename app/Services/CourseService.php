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

    public function create(array $data): Course
    {
        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            $data['thumbnail'] = $this->uploadService->uploadThumbnail($data['thumbnail']);
        }

        $data['slug'] = Str::slug($data['title']);
        return Course::create($data);
    }

    public function update(Course $course, array $data): Course
    {
        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $data['thumbnail'] = $this->uploadService->uploadThumbnail($data['thumbnail']);
        }

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $course->update($data);
        return $course;
    }
}
