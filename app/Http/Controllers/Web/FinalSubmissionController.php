<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FinalSubmission;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FinalSubmissionController extends Controller
{
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

        $lesson = Lesson::find($submission->lesson_id);
        $lesson->users()->attach(Auth::id(), ['is_completed' => true, 'completed_at' => now()]);

        if($submission->status == 'approved'){
            $lesson = Lesson::find($submission->lesson_id);
            $lesson->users()->attach(Auth::id(), ['is_completed' => true, 'completed_at' => now()]);
        }
        return redirect()->back()->with('success', 'Final submission updated successfully');
    }
}
