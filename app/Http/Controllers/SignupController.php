<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SignupController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name' => 'required|string|max:150',
            'email' => 'required|email|unique:residents,email|unique:users,email',
            'contact_number' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'id_type' => 'required|string|max:100',
            'resident_id_file' => 'required|file|extensions:jpg,jpeg,png,webp,avif,heic,heif,pdf|mimetypes:image/jpeg,image/jpg,image/png,image/webp,image/avif,image/heic,image/heif,image/heic-sequence,image/heif-sequence,application/pdf,application/octet-stream|max:10240',
            'birthdate' => 'required|date|before:today',
            'civil_status' => 'required|string|max:20',
            'purok' => 'required|string|max:100',
            'building_no' => 'required|string|max:100',
            'full_address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'cash_assistance_programs' => 'required|string|max:255',
        ], [
            'email.unique' => 'This email is already registered.',
            'birthdate.before' => 'Birthdate must be a past date.',
            'resident_id_file.extensions' => 'Supported file types: JPG, JPEG, PNG, WEBP, AVIF, HEIC, HEIF, PDF.',
            'resident_id_file.mimetypes' => 'This file type is not supported by iPhone upload handling. Please choose a JPG, HEIC, PNG, WEBP, AVIF, or PDF file.',
            'resident_id_file.max' => 'The ID file must not be greater than 10MB.',
        ]);

        try {
            $age = \Carbon\Carbon::parse($request->birthdate)->age;
            $fullName = trim($request->first_name . ' ' . ($request->middle_name ?? '') . ' ' . $request->last_name . ' ' . ($request->suffix ?? ''));
            $fullAddress = trim($request->building_no . ', ' . $request->purok . ', Bagacay, Dumaguete City');
            $residentIdFilePath = $request->file('resident_id_file')->store('resident-ids', 'public');

            $user = User::create([
                'name' => $fullName,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'password' => $request->password,
                'role' => 'resident',
                'age' => $age,
                'civil_status' => $request->civil_status,
                'id_type' => $request->id_type,
                'resident_id_file' => $residentIdFilePath,
                'purok' => $request->purok,
                'building_no' => $request->building_no,
                'barangay' => 'Bagacay',
                'city' => 'Dumaguete City',
                'full_address' => $fullAddress,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'is_indigent' => $request->cash_assistance_programs,
                'purpose' => 'Resident Registration',
                'date_issued' => now()->format('Y-m-d'),
            ]);

            Auth::login($user);
            return redirect()->route('user.dashboard')->with('success', 'Registration successful! Welcome to your dashboard.');
        } catch (\Exception $e) {
            if (isset($residentIdFilePath)) {
                Storage::disk('public')->delete($residentIdFilePath);
            }
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
