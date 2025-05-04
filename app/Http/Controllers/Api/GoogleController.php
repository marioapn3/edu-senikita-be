<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Firebase\JWT\JWK;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;
use phpseclib3\Math\BigInteger;

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

    // public function verifyGoogleToken(Request $request)
    // {

    //     $request->validate([
    //         'id_token' => 'required|string',
    //     ]);

    //     try {
    //         $client = new Google_Client([
    //             'client_id' => env('GOOGLE_CLIENT_ID')
    //         ]);


    //         $payload = $client->verifyIdToken($request->id_token);


    //         if (!$payload) {
    //             return response()->json(['status' => 'error', 'message' => 'Invalid ID token'], 401);
    //         }

    //         $email = $payload['email'];
    //         $name = $payload['name'] ?? 'User';
    //         $avatar = $payload['picture'] ?? null;

    //         $user = User::where('email', $email)->first();
    //         if (!$user) {
    //             $user = User::create([
    //                 'name' => $name,
    //                 'email' => $email,
    //                 'profile_picture' => $avatar,
    //                 'password' => bcrypt(Str::random(16)),
    //             ]);
    //         }

    //         $token = JWTAuth::fromUser($user);
    //         $user->token = $token;

    //         return $this->successResponse($user, 'User authenticated successfully', 200);
    //     } catch (Exception $e)
    //     {
    //         return $this->exceptionError($e, $e->getMessage());
    //     }

    // }


    // public function verifyGoogleToken(Request $request)
    // {
    //     $request->validate([
    //         'id_token' => 'required|string',
    //     ]);

    //     $idToken = $request->id_token;

    //     // Fetch Google's public keys
    //     $jwks = Http::get('https://www.googleapis.com/oauth2/v3/certs')->json();

    //     try {
    //         // Decode and verify the token
    //         $payload = JWT::decode($idToken, JWK::parseKeySet($jwks));

    //         // Check token expiration manually (optional)
    //         if (isset($payload->exp) && $payload->exp < time()) {
    //             return response()->json(['error' => 'Token expired'], 401);
    //         }

    //         // User handling
    //         $user = User::firstOrCreate(
    //             ['email' => $payload->email],
    //             [
    //                 'name' => $payload->name ?? 'User',
    //                 'profile_picture' => $payload->picture ?? null,
    //                 'password' => bcrypt(Str::random(16)),
    //             ]
    //         );

    //         $token = JWTAuth::fromUser($user);
    //         return response()->json([
    //             'user' => $user,
    //             'token' => $token,
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Invalid token',
    //             'details' => $e->getMessage(),
    //         ], 401);
    //     }
    // }
    function getGoogleJWKs() {
        $client = new Client();
        $response = $client->get('https://www.googleapis.com/oauth2/v3/certs');
        return json_decode($response->getBody()->getContents(), true);
    }

    function getKeyForJWT($kid, $keys) {
        foreach ($keys['keys'] as $key) {
            if ($key['kid'] === $kid) {
                return $key;
            }
        }
        throw new Exception('Key not found for kid: ' . $kid);
    }

    // function verifyJWT($idToken) {
        public function verifyGoogleToken(Request $request)
        {
            $request->validate([
                'id_token' => 'required|string',
            ]);
            $idToken = $request->id_token;
            $aud_check = env('GOOGLE_CLIENT_ID');
            $azp_check = env('GOOGLE_CLIENT_ID_ANDROID');
            try {
                $tokenParts = explode('.', $idToken);
                $header = json_decode(base64_decode($tokenParts[0]), true);

                $payload = json_decode(base64_decode($tokenParts[1]), true);
                $signature = base64_decode(strtr($tokenParts[2], '-_', '+/'));
                $kid = $header['kid'];
                $alg = $header['alg'];

                // Fetch Google's public keys
                $keys = $this->getGoogleJWKs();
                $key = $this->getKeyForJWT($kid, $keys);

                // Verify the audience and authorized party
                if (!isset($payload['aud']) || $payload['aud'] !== $aud_check) {
                    return response()->json(['error' => 'Invalid audience'], 401);
                }
                if (!isset($payload['azp']) || $payload['azp'] !== $azp_check) {
                    return response()->json(['error' => 'Invalid authorized party'], 401);
                }
                if (!isset($payload['iss']) || $payload['iss'] !== 'https://accounts.google.com') {
                    return response()->json(['error' => 'Invalid issuer'], 401);
                }
                // Check if the user exists in the database
                $user = User::where('email', $payload['email'])->first();
                if (!$user) {
                    $user = User::create([
                        'name' => $payload['name'] ?? 'User',
                        'email' => $payload['email'],
                        'google_id' => $payload['sub'],
                        'photo' => $payload['picture'] ?? null,
                    ]);
                }
                // Generate a JWT for the user
                $token = JWTAuth::fromUser($user);
                $user->token = $token;
                // Return the user and token
                return $this->successResponse(
                    $user,
                    'User authenticated successfully',
                    200
                );
            } catch (Exception $e) {
                return $this->exceptionError(
                    $e,
                    'Invalid token: ' . $e->getMessage()
                );
            }
        }

    public function verifyGoogleTokenV2(Request $request){
        $providerUser = null;

        $accessToken = $request->input('access_token');
        $provider = 'google';

        try {
            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);
        } catch (Exception $exception) {
            return $exception;
        }

        if ($providerUser) {
            return $this->findOrCreate($providerUser, $provider);
        }

        return $providerUser;
    }

}
