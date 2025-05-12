<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinalSubmission;
use App\Models\Lesson;
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
    public function allPublished()
    {
        $submissions = FinalSubmission::with('user')->where('is_published', true)->get();
        return $this->successResponse($submissions);
    }
    public function getByLessonId(Request $request, $lessonId)
    {
        $submissions = FinalSubmission::where('lesson_id', $lessonId);
        if(Auth::user()){
            $submissions->where('user_id', Auth::id());
        }
        $submissions = $submissions->get();
        return $this->successResponse($submissions);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lesson_id' => 'required|exists:lessons,id',
            'submission' => 'nullable|string',
            'file_path' => 'nullable|file|max:10240',
            'is_published' => 'required|boolean',
        ]);

        $lesson = Lesson::find($request->lesson_id);
        if($lesson->submission_type == 'file'){
            if(!$request->hasFile('file_path')){
                $validator->errors()->add('file_path', 'File is required');
            }
        }

        if($lesson->submission_type == 'text'){
            if(!$request->has('submission')){
                $validator->errors()->add('submission', 'Submission is required');
            }
        }

        if ($validator->fails()) {
            return $this->exceptionError($validator->errors(), 422);
        }

        $submission = new FinalSubmission();
        $submission->user_id = Auth::id();
        $submission->lesson_id = $request->lesson_id;
        $submission->submission = $request->submission;
        $submission->is_published = $request->is_published;
        $submission->type = $lesson->submission_type;
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


        if($submission->status == 'approved'){
            $lesson = Lesson::find($submission->lesson_id);
            $lesson->users()->attach(Auth::id(), ['is_completed' => true, 'completed_at' => now()]);

        }


        return $this->successResponse($submission, 'Final submission updated successfully');
    }
}
