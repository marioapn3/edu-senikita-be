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
    protected $quizService;

    public function __construct(UploadService $uploadService, QuizService $quizService)
    {
        $this->uploadService = $uploadService;
        $this->quizService = $quizService;
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
    public function getByCourseId($id, $request)
    {
        $userId = $request->user()->id;
        $lessons = Lesson::where('course_id', $id)
            ->with(['users' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->get()
            ->map(function ($lesson) use ($userId) {
                $completed = $lesson->users->first() ? $lesson->users->first()->pivot->is_completed : false;
                return [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'is_completed' => $completed ? true : false,
                    'slug' => $lesson->slug,
                    'order' => $lesson->order,
                    'type' => $lesson->type,
                    'description' => $lesson->description,
                    'content' => $lesson->content,
                    'video_url' => $lesson->video_url,
                    'duration' => $lesson->duration,
                    'created_at' => $lesson->created_at,
                    'updated_at' => $lesson->updated_at,
                    'completed_at' => $lesson->users->first() ? $lesson->users->first()->pivot->completed_at : null,
                ];
            });

        return $lessons;
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
            'duration',
        ]);

        if(isset($data['video_url'])) {
            if(!filter_var($data['video_url'], FILTER_VALIDATE_URL)) {
                throw new \Exception('Invalid video URL');
            }
            $data['video_url'] = str_replace('watch?v=', 'embed/', $data['video_url']);
        }


        if($this->checkOrderByCourseId($data['order'], $data['course_id'])) {
            throw new \Exception('Order already exists for this course');
        }

        $slug = Str::slug($data['title']);
        if(Lesson::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . Str::random(5);
        }
        $data['slug'] = $slug;

        $lesson = Lesson::create($data);
        if($data['type'] == 'quiz') {
            $request = [
                'lesson_id' => $lesson->id,
                'title' => $data['title'],
                'description' => $data['description'],
            ];
            $quiz = $this->quizService->createQuiz($request);
        }
        return $lesson;
    }

    public function checkOrderByCourseId($order, $course_id){
        $lesson = Lesson::where('course_id', $course_id)->where('order', $order)->first();
        if ($lesson) {
            return true;
        }
        return false;
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
            'duration',
        ]);

        if(isset($data['video_url'])) {
            if(!filter_var($data['video_url'], FILTER_VALIDATE_URL)) {
                throw new \Exception('Invalid video URL');
            }
            $data['video_url'] = str_replace('watch?v=', 'embed/', $data['video_url']);
        }

        $category->update($data);
        return $category;
    }

    public function completeLesson($lessonId, $userId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $lesson->users()->attach($userId, ['is_completed' => true, 'completed_at' => now()]);

        return $lesson;
    }

    public function getFinalLessons($userId)
    {
        return Lesson::where('type', 'final')
            ->whereHas('course.enrollments', function ($query) use ($userId) {
                $query->where('user_id', operator: $userId);
            })
            ->with(['course', 'users' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->get()
            ->map(function ($lesson) use ($userId) {
                $completed = $lesson->users->first() ? $lesson->users->first()->pivot->is_completed : false;
                return [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'slug' => $lesson->slug,
                    'description' => $lesson->description,
                    'course' => [
                        'id' => $lesson->course->id,
                        'title' => $lesson->course->title,
                        'slug' => $lesson->course->slug,
                        'thumbnail' => $lesson->course->thumbnail,
                    ],
                    'is_completed' => $completed,
                    'completed_at' => $lesson->users->first() ? $lesson->users->first()->pivot->completed_at : null,
                ];
            });
    }
}
