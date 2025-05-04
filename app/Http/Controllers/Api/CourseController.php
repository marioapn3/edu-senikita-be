<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }
    public function index(Request $request)
    {
        $validated = $request->validate([
            'limit' => 'integer|min:1|max:100',
            'search' => 'string|nullable',
        ]);

        $limit = $validated['limit'] ?? 10;
        $search = $validated['search'] ?? null;

        $courseQuery = Course::query();

        if ($search) {
            $courseQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $courses = $courseQuery->paginate($limit);

        return $this->respond([
            'data' => $courses->items(),
              'meta' => [
                'success' => true,
                'message' => 'Success get List',
                'pagination' => [
                    'total' => $courses->total(),
                    'per_page' => $courses->perPage(),
                    'current_page' => $courses->currentPage(),
                    'last_page' => $courses->lastPage(),
                ],
              ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'thumbnail' => 'nullable|image|max:2048', // max 2MB
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,published,archived'
        ]);

        $course = $this->courseService->create($validated);

        return $this->successResponse(
            $course,
            'Course created successfully',
            201
        );
    }



    public function show($id)
    {
        $course = Course::findOrFail($id);

        return  $this->successResponse(
            $course,
            'Course retrieved successfully'
        );
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required',
            'certificate_available' => 'sometimes|required|boolean',
            'thumbnail' => 'nullable|image|max:2048',
            'category' => 'sometimes|required|string|max:100',
            'status' => 'sometimes|required|in:draft,published,archived'
        ]);

        $course = $this->courseService->update($course, $validated);

        return $this->successResponse(
            $course,
            'Course updated successfully'
        );
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return $this->successResponse(
            null,
            'Course deleted successfully'
        );
    }
}
