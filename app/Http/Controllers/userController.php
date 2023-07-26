<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
    
        $expiresAt = Carbon::now()->addMinutes(30);

        $token = $user->createToken('my-app-token', ['expires_at' => $expiresAt])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
    
         return response($response, 201);
    }
}