<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        Log::info("Hit register user");

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'confirm_password.required' => 'The confirm password field is required.',
            'confirm_password.same' => 'The password and confirm password must match.',
        ]);

        if ($validator->fails()) {
            Log::info("Hit validation failed");
            return response()->json($validator->errors(), 202);
        }

        Log::info("Hit success validation");
        $hashed_password = Hash::make($request->password);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $hashed_password;
        $user->save();
        Log::info("Hit user saved successfully");
        return $user;
    }

    public function logout(Request $request)
    {

        Log::info("Hit Auth Logout");
        $user = $request->user();
        Log::info("User: " . $user);
        $response = $user->token()->delete();
        Log::info("Token delete: " . $response);
        Log::info("Hit Auth Logout 3");
        return response()->json(['message' => 'Successfully logged out']);
    }
}
