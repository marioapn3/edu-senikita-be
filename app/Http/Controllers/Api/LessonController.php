<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Models\Course;
use App\Services\LessonService;
use Exception;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    protected $lessonService;
    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
        $this->middleware(['auth:api', 'role:admin'])->only(['store', 'update', 'destroy']);
        $this->middleware(['auth:api'])->only(['showByCourseId', 'completeLesson']);
    }

    public function index(PaginationRequest $request){
        try {
            $data = $this->lessonService->getAll($request);
            return $this->respond($data);
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function show($id){
        try {
            $data = $this->lessonService->getById($id);
            return $this->successResponse($data, 'Lesson retrieved successfully');
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
    public function showByCourseId(Request $request,$course_id){
        try {
            $course = Course::find($course_id);

            if (!$course) {
                return response()->json([
                    'success' => false,
                    'message' => 'Course not found',
                    'errors' => []
                ], 404);
            }

            $data = $this->lessonService->getByCourseId($course_id, $request);

            return response()->json([
                'success' => true,
                'message' => 'Lesson retrieved successfully',
                'data' => $data,
                'additional_materials' => $course->additionalMaterials->map(function ($material) {
                    return [
                        'id' => $material->id,
                        'title' => $material->title,
                        'file_path' => $material->file_path,
                    ];
                })->toArray(),
            ]);
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
    public function showBySlug($slug){
        try {
            $data = $this->lessonService->getBySlug($slug);
            return $this->successResponse($data, 'Lesson retrieved successfully');
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function store(Request $request){
        try {
            $data = $this->lessonService->create($request);
            return $this->successResponse($data, 'Lesson created successfully',201);
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function update(Request $request, $id){
        try {
            $data = $this->lessonService->update($request, $id);
            return $this->successResponse($data, 'Lesson updated successfully');
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $this->lessonService->delete($id);
            return $this->successResponse('', 'Lesson deleted successfully');
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function completeLesson(Request $request, $lesson_id){
        try {
            $data = $this->lessonService->completeLesson($lesson_id, $request->user()->id);
            return $this->successResponse($data, 'Lesson completed successfully');
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
