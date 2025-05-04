<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleController extends Controller
{
    public function redirectToProvider()
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return redirect($url);
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

    public function verifyGoogleToken(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        try {
            $client = new Google_Client([
                'client_id' => [
                    env('GOOGLE_CLIENT_ID_ANDROID'),
                    env('GOOGLE_CLIENT_ID'),
                ]
            ]);

            $payload = $client->verifyIdToken($request->id_token);

            if (!$payload) {
                return response()->json(['status' => 'error', 'message' => 'Invalid ID token'], 401);
            }

            $email = $payload['email'];
            $name = $payload['name'] ?? 'User';
            $avatar = $payload['picture'] ?? null;

            $user = User::where('email', $email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'profile_picture' => $avatar,
                    'password' => bcrypt(Str::random(16)),
                ]);
            }

            $token = JWTAuth::fromUser($user);
            $user->token = $token;

            return $this->successResponse($user, 'User authenticated successfully', 200);
        } catch (Exception $e)
        {
            return $this->exceptionError($e, $e->getMessage());
        }

    }
}
