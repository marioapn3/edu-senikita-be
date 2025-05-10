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
        toastr()->success('Question created successfully');
        return response()->json(['message' => 'Question created successfully']);
    }

    public function createAnswer(Request $request, $questionId)
    {
        $this->quizService->createAnswer($request, $questionId);
        toastr()->success('Answer created successfully');
        return response()->json(['message' => 'Answer created successfully']);
    }

    public function deleteQuestion(Request $request, $questionId)
    {
        $this->quizService->deleteQuestion($questionId);
        toastr()->success('Question deleted successfully');
        return redirect()->back();
    }

    public function deleteAnswer($answerId)
    {
        $this->quizService->deleteAnswer($answerId);
        toastr()->success('Answer deleted successfully');
        return redirect()->back();
    }



}
