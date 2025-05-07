<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollment\StoreEnrollmentRequest;
use App\Http\Resources\Enrollment\ListEnrollmentResource;
use App\Services\EnrollmentService;
use Exception;
use Google\Service\AccessApproval\EnrolledService;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{

    protected $enrollmentService;
    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
        $this->middleware(['auth:api', 'role:user'])->only(['index','store','getTotalCourse']);
    }


    public function index(Request $request)
    {
        try {
            $data = $this->enrollmentService->getAll($request);
            return $this->respond(new ListEnrollmentResource($data));
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function store(StoreEnrollmentRequest $request)
    {
        try {
            $data = $this->enrollmentService->store($request);
            return $this->successResponse($data, 'Enrollment created successfully', 201);
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->enrollmentService->delete($id);
            return $this->successResponse([], 'Enrollment deleted successfully');
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function getTotalCourse(Request $request)
    {
        try {
            $data = $this->enrollmentService->getTotalCourse($request);
            return $this->successResponse($data, 'Total course retrieved successfully');
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

}
