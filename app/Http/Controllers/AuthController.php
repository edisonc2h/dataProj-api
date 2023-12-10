<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], '401');
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        if (isset($user['profile_id'])) {
            $profile = Profile::where('id', $user['profile_id'])->firstOrFail();
            if ($profile) {
                $profile->menu = json_decode($profile->menu, true);
                $user['profile'] = $profile;
            }
        }
        $token = $user->createToken($user['id'])->plainTextToken;

        return response()
            ->json([
                'message' => 'Hi '. $user->name,
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()
            ->json(['message' => 'successfully logout']);
    }
}
