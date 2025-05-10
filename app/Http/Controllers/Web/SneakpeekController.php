<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SneakpeekService;
use Illuminate\Http\Request;

class SneakpeekController extends Controller
{
    protected $sneakPeekService;
    public function __construct(SneakpeekService $sneakPeekService)
    {
        $this->sneakPeekService = $sneakPeekService;
    }

    public function create(Request $request, $courseId)
    {
       try{
        $this->sneakPeekService->create($request, $courseId);
        toastr()->success('Sneakpeek created successfully');
        return redirect()->back();
       } catch (\Exception $e) {
        toastr()->error('Sneakpeek creation failed');
        return redirect()->back();
       }
    }

    public function update(Request $request, $sneakPeekId)
    {
        try {
            $this->sneakPeekService->update($request, $sneakPeekId);
            toastr()->success('Sneakpeek updated successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Sneakpeek update failed');
            return redirect()->back();
        }
    }

    public function delete(Request $request, $sneakPeekId)
    {
        try {
            $this->sneakPeekService->delete($sneakPeekId);
            toastr()->success('Sneakpeek deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Sneakpeek deletion failed');
            return redirect()->back();
        }
    }




}
