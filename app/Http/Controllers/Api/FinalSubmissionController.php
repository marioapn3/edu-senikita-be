<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinalSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FinalSubmissionController extends Controller
{
    public function index()
    {
        $submissions = FinalSubmission::with(['user', 'course'])
            ->where('user_id', Auth::id())
            ->get();
        return response()->json(['data' => $submissions]);
    }

    public function show($id)
    {
        $submission = FinalSubmission::with(['user', 'course'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        return response()->json(['data' => $submission]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'submission' => 'required|string',
            'file' => 'nullable|file|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = [
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
            'submission' => $request->submission,
            'status' => 'pending',
        ];

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('final-submissions');
            $data['file_path'] = $path;
        }

        $submission = FinalSubmission::create($data);

        return response()->json([
            'message' => 'Final submission created successfully',
            'data' => $submission
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:reviewed,approved,rejected',
            'feedback' => 'required|string',
            'score' => 'required|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $submission = FinalSubmission::findOrFail($id);
        $submission->update($request->only(['status', 'feedback', 'score']));

        return response()->json([
            'message' => 'Final submission updated successfully',
            'data' => $submission
        ]);
    }

    public function download($id)
    {
        $submission = FinalSubmission::findOrFail($id);

        if (!$submission->file_path) {
            return response()->json(['message' => 'No file attached to this submission'], 404);
        }

        if (!Storage::exists($submission->file_path)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return Storage::download($submission->file_path);
    }
}
