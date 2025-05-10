<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\QuizService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function createQuestion(Request $request, $quizId)
    {


        $this->quizService->createQuestion($request, $quizId);
        return response()->json(['message' => 'Question created successfully']);
    }

    public function createAnswer(Request $request, $questionId)
    {
        $this->quizService->createAnswer($request, $questionId);
        return response()->json(['message' => 'Answer created successfully']);
    }

    public function deleteQuestion(Request $request, $questionId)
    {
        $this->quizService->deleteQuestion($questionId);
        return redirect()->back()->with('success', 'Question deleted successfully');
    }

    public function deleteAnswer($answerId)
    {
        $this->quizService->deleteAnswer($answerId);
        return redirect()->back()->with('success', 'Answer deleted successfully');
    }



}
