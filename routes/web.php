<?php

use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\AuthenticationController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\InstructorController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\LessonController;
use App\Http\Controllers\Web\QuizController as WebQuizController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;


Route::get('/', function () {
    return redirect()->route('login');
});
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'authenticate'])->name('authenticate');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    Route::prefix('instructors')->group(function () {
        Route::get('/', [InstructorController::class, 'index'])->name('instructors.index');
        Route::get('/create', [InstructorController::class, 'create'])->name('instructors.create');
        Route::post('/', [InstructorController::class, 'store'])->name('instructors.store');
        Route::get('/{id}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
        Route::put('/{id}', [InstructorController::class, 'update'])->name('instructors.update');
        Route::delete('/{id}', [InstructorController::class, 'destroy'])->name('instructors.destroy');
    });

    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/{id}', [CourseController::class, 'show'])->name('courses.show');
        Route::get('/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/{id}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');

        // Lesson routes
        Route::prefix('{courseId}/lessons')->group(function () {
            Route::get('/', [LessonController::class, 'index'])->name('courses.lessons.index');
            Route::get('/create', [LessonController::class, 'create'])->name('courses.lessons.create');
            Route::post('/', [LessonController::class, 'store'])->name('courses.lessons.store');
            Route::get('/{slug}', [LessonController::class, 'show'])->name('courses.lessons.show');
            Route::get('/{id}/edit', [LessonController::class, 'edit'])->name('courses.lessons.edit');
            Route::put('/{id}', [LessonController::class, 'update'])->name('courses.lessons.update');
            Route::delete('/{id}', [LessonController::class, 'destroy'])->name('courses.lessons.destroy');
        });

        Route::prefix('quiz')->group(function () {
            Route::prefix('/question')->group(function () {
                Route::post('/{quizId}', [WebQuizController::class, 'createQuestion'])->name('courses.quiz.question.create');
                Route::prefix('/{questionId}/answer')->group(function () {
                    Route::post('/', [WebQuizController::class, 'createAnswer'])->name('courses.quiz.question.answer.create');
                });
                Route::delete('/{questionId}', [WebQuizController::class, 'deleteQuestion'])->name('courses.quiz.question.delete');
            });
        });

        Route::delete('answer/{answerId}', [WebQuizController::class, 'deleteAnswer'])->name('quiz.answer.delete');


    });

    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
});


