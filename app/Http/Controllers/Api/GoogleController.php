<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleController extends Controller
{
    public function redirectToProvider()
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json([
            'status' => 'success',
            'message' => 'Google login URL generated',
            'url' => $url,
        ], 200);
    }

    public function handleProvideCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (Exception $e) {
            return redirect()->back();
        }
        // find or create user and send params user get from socialite and provider
        $authUser = $this->findOrCreateUser($user);

        $token = JWTAuth::fromUser($authUser);

        // $redirectUrl = 'https://senikita.my.id/callback-google?jwt_token=' . urlencode($token);
        $redirectUrl = env('FRONTEND_URL') . '/callback-google?jwt_token=' . urlencode($token);

        return redirect()->away($redirectUrl);
    }

    public function findOrCreateUser($socialUser)
    {
        // Get Social Account
        $user = User::where('email', $socialUser->getEmail())
            ->first();

        if (!$user) {
            $user = User::create([
                'name'  => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'google_id' => $socialUser->getId(),
                'photo' => $socialUser->getAvatar(),
            ]);
        }

        return $user;

    }
}
