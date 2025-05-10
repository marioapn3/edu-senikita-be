<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinalSubmission;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FinalSubmissionController extends Controller
{
    protected $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    public function getByLessonId($lessonId)
    {
        $submissions = FinalSubmission::where('lesson_id', $lessonId)->get();
        return $this->successResponse($submissions);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lesson_id' => 'required|exists:lessons,id',
            'submission' => 'required|string',
            'file_path' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return $this->exceptionError($validator->errors(), 422);
        }

        $submission = new FinalSubmission();
        $submission->user_id = Auth::id();
        $submission->lesson_id = $request->lesson_id;
        $submission->submission = $request->submission;

        if ($request->hasFile('file_path')) {
            $path = $this->uploadService->upload($request->file('file_path'), 'final-submissions');
            $submission->file_path = $path;
        }

        $submission->save();

        return $this->successResponse($submission, 'Final submission created successfully', 201);
    }
    public function score(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'required|string',
            'status' => 'required|in:reviewed,approved,rejected',
        ]);

        if ($validator->fails()) {
            return $this->exceptionError($validator->errors(), 422);
        }

        $submission = FinalSubmission::findOrFail($id);
        $submission->score = $request->score;
        $submission->feedback = $request->feedback;
        $submission->status = $request->status;
        $submission->save();

        return $this->successResponse($submission, 'Final submission updated successfully');
    }
}
