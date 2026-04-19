<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SignupController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name' => 'required|string|max:150',
            'email' => 'required|email|unique:residents,email|unique:users,email',
            'password' => 'required|string|min:6',
            'birthdate' => 'required|date|before:today',
            'civil_status' => 'required|string|max:20',
            'purok' => 'required|string|max:100',
            'full_address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'cash_assistance_programs' => 'required|string|max:255',
        ], [
            'email.unique' => 'This email is already registered.',
            'birthdate.before' => 'Birthdate must be a past date.',
        ]);

        try {
            $age = \Carbon\Carbon::parse($request->birthdate)->age;
            $fullName = trim($request->first_name . ' ' . ($request->middle_name ?? '') . ' ' . $request->last_name . ' ' . ($request->suffix ?? ''));

            $user = User::create([
                'name' => $fullName,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'resident',
                'age' => $age,
                'civil_status' => $request->civil_status,
                'purok' => $request->purok,
                'barangay' => 'Bagacay',
                'city' => 'Dumaguete City',
                'full_address' => $request->full_address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'is_indigent' => $request->cash_assistance_programs,
                'purpose' => 'Resident Registration',
                'date_issued' => now()->format('Y-m-d'),
            ]);

            Auth::login($user);
            return redirect()->route('user.dashboard')->with('success', 'Registration successful! Welcome to your dashboard.');
        } catch (\Exception $e) {
            Log::error('Registration failed for email ' . $request->email . ': ' . $e->getMessage());
            return back()->with('error', 'Registration failed. Please try again.')->withInput($request->except('password'));
        }
    }

    public function LoginUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $user = User::where('email', $request->username)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                if ($user->role === 'admin') {
                    return redirect()->route('home.admin')->with('success', 'Admin login successful!');
                }
                return redirect()->route('user.dashboard')->with('success', 'Login successful!');
            }

            return back()->with('error', 'Invalid username or password.');
        } catch (\Exception $e) {
            Log::error('Login error for user ' . $request->username . ': ' . $e->getMessage());
            return back()->with('error', 'An error occurred during login. Please try again.');
        }
    }
}
