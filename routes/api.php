<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\GoogleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('auth/google', [GoogleController::class, 'redirectToProvider']);
Route::get('auth/google/callback', [GoogleController::class, 'handleProvideCallback']);

Route::apiResource('courses', CourseController::class);
