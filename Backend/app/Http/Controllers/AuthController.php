<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegisterNotification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email|max:255',
            'password' => [
                'unique:users,password',
                'required',
                'string',
                'min:12',
                'max:255',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
                'not_in:password,12345678,qwerty,admin123',
            ],
            'password_confirmation' => 'required|same:password',
        ]);

        try {
            $hasMx = checkdnsrr(explode('@', $request->email)[1], 'MX');
        } catch (\Exception $e) {
            $hasMx = false;
        }
        if (!$hasMx) {
            return back()->withErrors(['email' => 'Invalid email domain.']);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Notification::send($user, new RegisterNotification($user));
        return response()->json([
            'message' => 'User created successfully',
            'email' => $user->email,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (RateLimiter::tooManyAttempts('login:'.$request->ip(), 5)) {
            return response()->json([
                'message' => 'Too many login attempts. Please try again later.',
            ], 429);
        }

        RateLimiter::hit('login:'.$request->ip());

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'Email not found',
            ], 401);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Password is incorrect',
            ], 401);
        }

        // Create new token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Update user's auth_token
        $user->update([
            'auth_token' => $token
        ]);

        // Create secure cookie
        $cookie = cookie('auth_token', $token, 60*24*30, null, null, true, true, false, 'strict');

        return response()->json([
            'message' => 'Login successful',
            'email' => $user->email,
            'token' => $token,
        ])->withCookie($cookie);
    }

    public function logout(Request $request)
    {
        $cookie = cookie()->forget('auth_token');
        return response()->json(['message' => 'Logged out'])->withCookie($cookie);
    }
}
