<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\AdditionalMaterialService;
use Illuminate\Http\Request;

class AdditionalMaterialController extends Controller
{
    protected $additionalMaterialService;

    public function __construct(AdditionalMaterialService $additionalMaterialService)
    {
        $this->additionalMaterialService = $additionalMaterialService;
    }

    public function create(Request $request){
        try{
            $request->validate([
                'title' => 'required|string|max:255',
                'file' => 'required|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png,gif,svg,webp,mp3',
                'course_id' => 'required|exists:courses,id',
            ]);
            $additionalMaterial = $this->additionalMaterialService->create($request);
            return redirect()->back()->with('success', 'Additional material created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function delete($id){
        try{
            $this->additionalMaterialService->delete($id);
            return redirect()->back()->with('success', 'Additional material deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete additional material');
        }
    }
}
