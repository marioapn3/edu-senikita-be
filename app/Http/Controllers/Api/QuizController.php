<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{

    public function getQuizByLessonId($lessonId)
    {
        $quiz = Quiz::with(['questions.answers', 'attempts' => function($query) {
            $query->where('user_id', Auth::id());
        }])->where('lesson_id', $lessonId)->first();

        return $this->successResponse($quiz);
    }

    public function submitAttempt(Request $request, $lessonId)
    {
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:quiz_questions,id',
            'answers.*.quiz_answer_id' => 'required|exists:quiz_answers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $quiz = Quiz::where('lesson_id', $lessonId)->first();
        $attempt = UserQuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'started_at' => now(),
            'completed_at' => now(),
        ]);

        $totalScore = 0;
        $maxScore = 0;

        foreach ($request->answers as $answer) {
            $question = QuizQuestion::find($answer['question_id']);
            $maxScore += $question->points;

            if ($question->type === 'multiple_choice' || $question->type === 'true_false') {
                $selectedAnswer = QuizAnswer::find($answer['quiz_answer_id']);
                if ($selectedAnswer && $selectedAnswer->is_correct) {
                    $totalScore += $question->points;
                }
            }
        }

        $attempt->update([
            'score' => $totalScore,
            'is_passed' => ($totalScore / $maxScore * 100) >= $quiz->passing_score,
        ]);

        if ($attempt->is_passed) {
            $lesson = Lesson::find($lessonId);
            $lesson->users()->attach(Auth::id(), ['is_completed' => true, 'completed_at' => now()]);
        }



        return response()->json([
            'message' => 'Quiz attempt submitted successfully',
            'data' => [
                'score' => $totalScore,
                'max_score' => $maxScore,
                'is_passed' => $attempt->is_passed,
            ]
        ]);
    }
}
