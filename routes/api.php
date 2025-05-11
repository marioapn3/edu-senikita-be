<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseRatingController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\FinalSubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->post('onboarding', [AuthController::class, 'updateOnboarding']);

    // Google Auth Routes
    Route::get('google', [GoogleController::class, 'redirectToProvider']);
    Route::get('google/callback', [GoogleController::class, 'handleProvideCallback']);
    Route::post('google/verify-code', [GoogleController::class, 'verifyGoogleToken']);
    Route::post('google/verify-code-v2', [GoogleController::class, 'verifyGoogleTokenV2']);
});

// User Routes
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'User data retrieved successfully',
        'data' => [
            'user' => $request->user(),
            'token' => $request->bearerToken(),
        ]
    ]);
});

// Course Routes
Route::controller(CourseController::class)->group(function () {
    Route::get('courses', 'index');
    Route::post('courses', 'store');
    Route::get('courses/{id}', 'show');
    Route::put('courses/{id}', 'update');
    Route::delete('courses/{id}', 'destroy');
    Route::get('courses/slug/{slug}', 'showBySlug');
});

// Category Routes
Route::controller(CategoryController::class)->group(function () {
    Route::get('categories', 'index');
    Route::post('categories', 'store');
    Route::get('categories/{id}', 'show');
    Route::post('categories/{id}', 'update');
    Route::delete('categories/{id}', 'destroy');
    Route::get('categories/slug/{slug}', 'showBySlug');
});

// Lesson Routes
Route::controller(LessonController::class)->group(function () {
    Route::get('lessons', 'index');
    Route::post('lessons', 'store');
    Route::get('lessons/{id}', 'show');
    Route::put('lessons/{id}', 'update');
    Route::delete('lessons/{id}', 'destroy');
    Route::get('lessons/slug/{slug}', 'showBySlug');
    Route::post('lessons/{lesson_id}/complete', 'completeLesson');
    Route::get('course/lessons/{course_id}', 'showByCourseId');
});

// Enrollment Routes
Route::controller(EnrollmentController::class)->group(function () {
    Route::get('enrollments', 'index');
    Route::post('enrollments', 'store');
    Route::delete('enrollments/{id}', 'destroy');
    Route::get('enrollments/total-course', 'getTotalCourse');
});

// Course Rating Routes
Route::controller(CourseRatingController::class)->group(function () {
    Route::post('course-ratings', 'store');
});

// Quiz Routes
Route::middleware('auth:api')->group(function () {
    Route::get('quizzes/lesson/{lesson_id}', [QuizController::class, 'getQuizByLessonId']);
    Route::post('quizzes/submit/{lesson_id}', [QuizController::class, 'submitAttempt']);

});

Route::middleware('auth:api')->prefix('final-submissions')->group(function () {
    Route::get('/{lessonId}', [FinalSubmissionController::class, 'getByLessonId'])->name('final-submissions.getByLessonId');
    Route::post('/', [FinalSubmissionController::class, 'store'])->name('final-submissions.store');
    Route::put('/score/{id}', [FinalSubmissionController::class, 'score'])->name('final-submissions.score');
});

Route::middleware('auth:api')->prefix('certificates')->group(function () {
    Route::get('/', [CertificateController::class, 'getAll'])->name('certificates.getAll');
});


Route::get('/published', [FinalSubmissionController::class, 'allPublished'])->name('final-submissions.allPublished');


require __DIR__ . '/debug.php';
