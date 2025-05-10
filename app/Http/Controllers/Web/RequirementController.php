<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\RequirementService;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    protected $requirementService;
    public function __construct(RequirementService $requirementService)
    {
        $this->requirementService = $requirementService;
    }

    public function create(Request $request, $courseId)
    {
        try {
            $this->requirementService->create($request, $courseId);
            toastr()->success('Requirement created successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Requirement creation failed');
            return redirect()->back();
        }

    }

    public function update(Request $request, $requirementId)
    {
       try {
        $this->requirementService->update($request, $requirementId);
        toastr()->success('Requirement updated successfully');
        return redirect()->back();
       } catch (\Exception $e) {
        toastr()->error('Requirement update failed');
        return redirect()->back();
       }
    }

    public function delete(Request $request, $requirementId)
    {
       try {
        $this->requirementService->delete($requirementId);
        toastr()->success('Requirement deleted successfully');
        return redirect()->back();
       } catch (\Exception $e) {
        toastr()->error('Requirement deletion failed');
        return redirect()->back();
       }
    }




}
