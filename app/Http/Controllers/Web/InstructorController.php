<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\InstructorService;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    protected $instructorService;

    public function __construct(InstructorService $instructorService)
    {
        $this->instructorService = $instructorService;
    }

    public function index(Request $request)
    {
        $instructors = $this->instructorService->getAll($request);
        return view('pages.dashboard.instructors.index', compact('instructors'));
    }

    public function create()
    {
        return view('pages.dashboard.instructors.create');
    }

    public function store(Request $request)
    {
        $this->instructorService->create($request);
        return redirect()->route('instructors.index')->with('success', 'Instructor created successfully');
    }

    public function edit($id)
    {
        $instructor = $this->instructorService->getById($id);
        return view('pages.dashboard.instructors.edit', compact('instructor'));
    }

    public function update(Request $request, $id)
    {
        $this->instructorService->update($id, $request);
        return redirect()->route('instructors.index')->with('success', 'Instructor updated successfully');
    }

    public function destroy($id)
    {
        $this->instructorService->delete($id);
        return redirect()->route('instructors.index')->with('success', 'Instructor deleted successfully');
    }
}
