<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\LessonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', [AuthController::class, 'login']);
Route::get('auth/google', [GoogleController::class, 'redirectToProvider']);
Route::get('auth/google/callback', [GoogleController::class, 'handleProvideCallback']);
Route::post('auth/google/verify-code', [GoogleController::class, 'verifyGoogleToken']);

Route::apiResource('courses', CourseController::class);
Route::get('courses/slug/{slug}', [CourseController::class, 'showBySlug']);
Route::apiResource('categories', CategoryController::class);
Route::get('categories/slug/{slug}', [CategoryController::class, 'showBySlug']);

Route::apiResource('lessons', LessonController::class);
Route::get('lessons/slug/{slug}', [LessonController::class, 'showBySlug']);
Route::get('course/lessons/{course_id}', [LessonController::class, 'showByCourseId']);
