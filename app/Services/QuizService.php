<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;
use App\Models\UserQuizAttempt;


class QuizService
{
    public function createQuiz($request)
    {
        $data = is_array($request) ? $request : $request->only([
            'lesson_id',
            'title',
            'description',
        ]);

        $quiz = Quiz::create($data);

        return $quiz;
    }

    public function updateQuiz($request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $data = $request->only([
            'title',
            'description',
            'passing_score',
            'is_active',
        ]);

        $quiz->update($data);

        return $quiz;
    }

    public function deleteQuiz($id)
    {
        $quiz = Quiz::findOrFail($id);

        $quiz->delete();
    }

    public function getQuizByLessonId($lessonId)
    {
        $quiz = Quiz::where('lesson_id', $lessonId)->first();

        return $quiz;
    }

    public function getQuizById($id)
    {
        $quiz = Quiz::findOrFail($id);

        return $quiz;
    }

    public function createQuestion($request, $quizId)
    {
        $data = $request->only([
            'question',
            'type',
        ]);
        $data['quiz_id'] = $quizId;

        $question = QuizQuestion::create($data);

        return $question;
    }

    public function updateQuestion($request, $id)
    {
        $question = QuizQuestion::findOrFail($id);

        $question->update($request->only(['question', 'type']));

        return $question;
    }

    public function deleteQuestion($id)
    {
        $question = QuizQuestion::findOrFail($id);

        $question->delete();
    }

    public function createAnswer($request, $questionId)
    {
        $data = $request->only([
            'answer',
            'is_correct',
        ]);
        $data['quiz_question_id'] = $questionId;

        $answer = QuizAnswer::create($data);

        return $answer;
    }

    public function updateAnswer($request, $id)
    {
        $answer = QuizAnswer::findOrFail($id);

        $answer->update($request->only(['answer', 'is_correct']));

        return $answer;
    }


    public function deleteAnswer($id)
    {
        $answer = QuizAnswer::findOrFail($id);

        $answer->delete();
    }


}
