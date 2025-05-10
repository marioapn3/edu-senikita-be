<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with(['lesson'])->get();
        return response()->json(['data' => $quizzes]);
    }

    public function show($id)
    {
        $quiz = Quiz::with(['questions.answers'])->findOrFail($id);
        return response()->json(['data' => $quiz]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'required|integer|min:0|max:100',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,true_false,essay',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.answers' => 'required_if:questions.*.type,multiple_choice,true_false|array',
            'questions.*.answers.*.answer' => 'required|string',
            'questions.*.answers.*.is_correct' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $quiz = Quiz::create($request->only(['lesson_id', 'title', 'description', 'passing_score']));

        foreach ($request->questions as $questionData) {
            $question = $quiz->questions()->create([
                'question' => $questionData['question'],
                'type' => $questionData['type'],
                'points' => $questionData['points'],
            ]);

            if (isset($questionData['answers'])) {
                foreach ($questionData['answers'] as $answerData) {
                    $question->answers()->create([
                        'answer' => $answerData['answer'],
                        'is_correct' => $answerData['is_correct'],
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Quiz created successfully', 'data' => $quiz->load('questions.answers')], 201);
    }

    public function submitAttempt(Request $request, $quizId)
    {
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:quiz_questions,id',
            'answers.*.answer' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $quiz = Quiz::findOrFail($quizId);
        $attempt = UserQuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quizId,
            'started_at' => now(),
            'completed_at' => now(),
        ]);

        $totalScore = 0;
        $maxScore = 0;

        foreach ($request->answers as $answer) {
            $question = QuizQuestion::find($answer['question_id']);
            $maxScore += $question->points;

            if ($question->type === 'multiple_choice' || $question->type === 'true_false') {
                $correctAnswer = $question->answers()->where('is_correct', true)->first();
                if ($correctAnswer && $correctAnswer->answer === $answer['answer']) {
                    $totalScore += $question->points;
                }
            }
        }

        $attempt->update([
            'score' => $totalScore,
            'is_passed' => ($totalScore / $maxScore * 100) >= $quiz->passing_score,
        ]);

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
