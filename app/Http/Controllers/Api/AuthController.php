<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    /**
 * Log in a user
 * 
 * This endpoint allows a user to log in using their phone and password.
 * 
 * @bodyParam phone string required The user's phone number. Example: 26659123456
 * @bodyParam password string required The user's password. Example: secret
 *
 * @response 200 {
 *   "user": {
 *     "id": 1,
 *     "name": "Amo",
 *     "phone": "26659123456"
 *   },
 *   "token": "long-auth-token"
 * }
 */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('phone', $credentials['phone'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }
}