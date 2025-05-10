<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Services\InstructorService;
use App\Services\CategoryService;
use App\Services\LessonService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseService;
    protected $instructorService;
    protected $categoryService;
    protected $lessonService;

    public function __construct(
        CourseService $courseService,
        InstructorService $instructorService,
        CategoryService $categoryService,
        LessonService $lessonService
    ) {
        $this->courseService = $courseService;
        $this->instructorService = $instructorService;
        $this->categoryService = $categoryService;
        $this->lessonService = $lessonService;
    }

    public function index(Request $request)
    {
        $courses = $this->courseService->getAll($request);
        return view('pages.dashboard.courses.index', compact('courses'));
    }

    public function create()
    {
        $instructors = $this->instructorService->all();
        $categories = $this->categoryService->all();
        return view('pages.dashboard.courses.create', compact('instructors', 'categories'));
    }

    public function store(Request $request)
    {
        $this->courseService->create($request);
        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }

    public function edit($id)
    {
        $course = $this->courseService->getById($id, request());
        $instructors = $this->instructorService->all();
        $categories = $this->categoryService->all();
        return view('pages.dashboard.courses.edit', compact('course', 'instructors', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->courseService->update($id, $request);
        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    public function destroy($id)
    {
        $this->courseService->delete($id);
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }


    public function show($id)
    {
        $course = $this->courseService->getById($id, request());
        $lessons = $this->lessonService->getByCourseId($course->id, request());
        return view('pages.dashboard.courses.show', compact('course', 'lessons'));
    }
}
