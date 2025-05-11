<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;
use App\Models\UserQuizAttempt;
use App\Models\UserQuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{

    public function getQuizByLessonId($lessonId)
    {
        $quiz = Quiz::with(['questions.answers', 'attempts' => function($query) {
            $query->where('user_id', Auth::id())
                  ->with(['answers.question', 'answers.answer'])
                  ->latest();
        }])->where('lesson_id', $lessonId)->first();

        $history = [];
        $latestAttempt = null;
        if ($quiz && $quiz->attempts->isNotEmpty()) {
            $latestAttempt = $quiz->attempts->first();
            foreach ($quiz->questions as $question) {
                $userAnswer = $latestAttempt->answers->firstWhere('quiz_question_id', $question->id);
                $history[] = [
                    'question' => $question,
                    'user_answer' => $userAnswer ? [
                        'selected_answer' => $userAnswer->answer,
                        'is_correct' => $userAnswer->is_correct
                    ] : null
                ];
            }
        }

        return $this->successResponse([
            'quiz' => $quiz,
            'history' => $history,
            'latest_attempt' => $latestAttempt ? [
                'id' => $latestAttempt->id,
                'user_id' => $latestAttempt->user_id,
                'quiz_id' => $latestAttempt->quiz_id,
                'score' => $latestAttempt->score,
                'is_passed' => $latestAttempt->is_passed,
                'started_at' => $latestAttempt->started_at,
                'completed_at' => $latestAttempt->completed_at,
                'created_at' => $latestAttempt->created_at,
                'updated_at' => $latestAttempt->updated_at
            ] : null
        ]);
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
                $isCorrect = $selectedAnswer && $selectedAnswer->is_correct;

                if ($isCorrect) {
                    $totalScore += $question->points;
                }

                // Store the user's answer
                UserQuizAnswer::create([
                    'user_quiz_attempt_id' => $attempt->id,
                    'quiz_question_id' => $question->id,
                    'quiz_answer_id' => $selectedAnswer->id,
                    'is_correct' => $isCorrect,
                ]);
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
                'attempt' => $attempt->load(['answers.question', 'answers.answer']),
            ]
        ]);
    }
}
