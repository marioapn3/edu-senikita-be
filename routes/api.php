<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseRatingController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\LessonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;


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

Route::post('auth/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('auth/onboarding', [AuthController::class, 'updateOnboarding']);

Route::get('auth/google', [GoogleController::class, 'redirectToProvider']);
Route::get('auth/google/callback', [GoogleController::class, 'handleProvideCallback']);
Route::post('auth/google/verify-code', [GoogleController::class, 'verifyGoogleToken']);
Route::post('auth/google/verify-code-v2', [GoogleController::class, 'verifyGoogleTokenV2']);

Route::apiResource('courses', CourseController::class);
Route::get('courses/slug/{slug}', [CourseController::class, 'showBySlug']);

Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::post('categories/{id}', [CategoryController::class, 'update']);
Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
Route::get('categories/slug/{slug}', [CategoryController::class, 'showBySlug']);

Route::apiResource('lessons', LessonController::class);
Route::get('lessons/slug/{slug}', [LessonController::class, 'showBySlug']);
Route::post('lessons/{lesson_id}/complete', [LessonController::class, 'completeLesson']);   
Route::get('course/lessons/{course_id}', [LessonController::class, 'showByCourseId']);

Route::get('debug-playground', function(){
    $idToken = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjA3YjgwYTM2NTQyODUyNWY4YmY3Y2QwODQ2ZDc0YThlZTRlZjM2MjUiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJhenAiOiI4MjY0NjE5Mzk1MS02NjZnY3Rtc3Y1ZnBhZ2tnbmZrZGRoY2FnNWtvb3AzYS5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsImF1ZCI6IjgyNjQ2MTkzOTUxLXV1bWpsdGlhYm5kcTVodThyYzlyOXRxMWF1bzZmZGt0LmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwic3ViIjoiMTE1MTc3Nzg3MzUyODA1ODE1MzAwIiwiZW1haWwiOiJyaWNreXByaW1hMzBAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsIm5hbWUiOiJSaWNreSBQcmltYSIsInBpY3R1cmUiOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vYS9BQ2c4b2NKaGw1RHAzTklObXcyS21CcktyUFZQR2hnRVZZVi1NVzJpNWV1aFdnanQyS0hIMHRWVz1zOTYtYyIsImdpdmVuX25hbWUiOiJSaWNreSIsImZhbWlseV9uYW1lIjoiUHJpbWEiLCJpYXQiOjE3NDYzNzE1OTYsImV4cCI6MTc0NjM3NTE5Nn0.azJY0gBeETyv0kWMTDy_BMIVQ8rW4c4zzynW-J8A9_JAgFS7j9Q7_f8LH1MPvyB2Nlu0iwi94a3MeFqtGf7GrrlROkQcUIGYDqorMQOdqSL7_qUs84z3pSc1Oa1YQgFaKXB1gYzs0ZvhHj9k-qPTFxUx8mMVcaQlKzsWMlX_Vm5CEHE-RPbuNPP8Jw6IZFdqnLpqJPxBgTdrbEFBfqIc7J9Z80NhdhAtCcfvs_eJt-A";

// Split the token into parts
$tokenParts = explode('.', $idToken);
$header = json_decode(base64_decode($tokenParts[0]), true);
$payload = json_decode(base64_decode($tokenParts[1]), true);
$signature = base64_decode(strtr($tokenParts[2], '-_', '+/'));

// Check the payload
dd($header, $payload);
});

Route::controller(EnrollmentController::class)->group(function () {
    Route::get('enrollments', 'index');
    Route::post('enrollments', 'store');
    Route::delete('enrollments/{id}', 'destroy');
});

Route::controller(CourseRatingController::class)->group(function () {
    Route::post('course-ratings', 'store');
});
