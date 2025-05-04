<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->exceptionError($validator->errors(), $validator->errors());
        }

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return $this->exceptionError('Unauthorized', 'Invalid credentials', 401);
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        $user->token = $token;

        return $this->successResponse($user, 'Login successful');
    }
}
