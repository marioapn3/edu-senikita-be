<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollment\StoreEnrollmentRequest;
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
        $this->middleware(['auth:api', 'role:user'])->only(['index','store']);
    }


    public function index(Request $request)
    {
        try {
            $data = $this->enrollmentService->getAll($request);
            return $this->respond($data);
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

}
