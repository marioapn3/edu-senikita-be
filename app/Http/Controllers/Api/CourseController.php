<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\Course\ListCourseResource;
use App\Models\Course;
use App\Services\CategoryService;
use App\Services\CourseService;
use App\Services\InstructorService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    protected $courseService;
    protected $categoryService;
    protected $instructorService;

    public function __construct(CourseService $courseService, CategoryService $categoryService, InstructorService $instructorService)
    {
        $this->courseService = $courseService;
        $this->categoryService = $categoryService;
        $this->instructorService = $instructorService;
        $this->middleware(['auth:api', 'role:admin'])->only(['store', 'update', 'destroy']);

    }
    public function index(PaginationRequest $request)
    {
        try {
            $data = $this->courseService->getAll($request);
            return $this->respond(new ListCourseResource($data));
        } catch (\Exception $e) {
            return $this->exceptionError($e,$e->getMessage() );
        }
    }

    public function store(StoreCourseRequest $request)
    {
        try {
            $course = $this->courseService->create($request);
            return $this->successResponse($course,'Course created successfully',201);
        } catch (\Exception $e) {
            return $this->exceptionError($e,$e->getMessage() );
        }
    }


    public function show(Request $request, $id)
    {
        try {
            $course = $this->courseService->getById($id, $request);
            return $this->successResponse(new CourseResource($course),'Course retrieved successfully');
        } catch (\Exception $e) {
            return $this->exceptionError($e,$e->getMessage() );
        }
    }

    public function showBySlug(Request $request, $slug)
    {
        try {
            $course = $this->courseService->getBySlug($slug, $request);
            return $this->successResponse(new CourseResource($course),'Course retrieved successfully');
        } catch (\Exception $e) {
            return $this->exceptionError($e,$e->getMessage() );
        }
    }

    public function update(UpdateCourseRequest $request, $id)
    {
       try {
            $course = $this->courseService->update($id, $request);
            return $this->successResponse($course,'Course updated successfully');
        } catch (\Exception $e) {
            return $this->exceptionError($e,$e->getMessage() );
        }
    }

    public function destroy($id)
    {
        try {
            $this->courseService->delete($id);
            return $this->successResponse(null,'Course deleted successfully');
        } catch (\Exception $e) {
            return $this->exceptionError($e,$e->getMessage() );
        }
    }
}
