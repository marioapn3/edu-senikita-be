<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRatingRequest;
use App\Services\CourseRatingService;
use Illuminate\Http\Request;

class CourseRatingController extends Controller
{
    protected $courseRatingService;
    public function __construct(CourseRatingService $courseRatingService)
    {
        $this->courseRatingService = $courseRatingService;
        $this->middleware(['auth:api', 'role:user'])->only(['store']);
    }

    public function store(CourseRatingRequest $request)
    {
        try {
            $courseRating = $this->courseRatingService->create($request);
            return $this->successResponse(
                'Course rating created successfully',
                $courseRating,
                201
            );
        } catch (\Exception $e) {
            return $this->exceptionError(
                'Failed to create course rating',
                $e->getMessage(),
                500
            );
        }
    }
}
