<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Services\LessonService;
use App\Services\QuizService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    protected $lessonService;
    protected $courseService;
    protected $quizService;

    public function __construct(LessonService $lessonService, CourseService $courseService, QuizService $quizService)
    {
        $this->lessonService = $lessonService;
        $this->courseService = $courseService;
        $this->quizService = $quizService;
    }

    public function index($courseId, Request $request)
    {
        $lessons = $this->lessonService->getByCourseId($courseId, $request);
        return view('pages.dashboard.lessons.index', compact('lessons', 'courseId'));
    }

    public function create($courseId)
    {
        return view('pages.dashboard.lessons.form', compact('courseId'));
    }

    public function store(Request $request, $courseId)
    {
        try {
            $request->merge(['course_id' => $courseId]);
            $this->lessonService->create($request);

            return redirect()->route('courses.show', $courseId)
                ->with('success', 'Lesson created successfully');
        } catch (\Exception $e) {
            return redirect()->route('courses.show', $courseId)
                ->with('error', 'Failed to create lesson');
        }

    }

    public function edit($courseId, $id)
    {
        $lesson = $this->lessonService->getById($id);
        return view('pages.dashboard.lessons.form', compact('lesson', 'courseId'));
    }

    public function update(Request $request, $courseId, $id)
    {
        $this->lessonService->update($id, $request);
        return redirect()->route('courses.show', $courseId)
        ->with('success', 'Lesson created successfully');
    }

    public function destroy($courseId, $id)
    {
        $this->lessonService->delete($id);
        return redirect()->route('courses.show', $courseId)
            ->with('success', 'Lesson deleted successfully');
    }

    public function show($courseId, $slug)
    {
        $lesson = $this->lessonService->getBySlug($slug);
        $quiz = $this->quizService->getQuizByLessonId($lesson->id);
        return view('pages.dashboard.lessons.show', compact('lesson', 'courseId', 'quiz'));
    }
}
