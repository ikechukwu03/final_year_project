<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Finalist;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function showRegisterForm()
    {
        return view('student.signupPage');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'matric_no' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Check if student exists in finalists
        $finalist = Finalist::where('name', $request->input ("name"))
            ->where('email', $request->input ("email"))
            ->where('matric_no', $request-> input ("matric_no"))
            ->first();

        if (!$finalist) {
            return redirect()->back()->with('error', 'You are not listed as a finalist.');
        }

        // Check if user is already registered
        if (User::where('email', $request->input ("email"))->orWhere('matric_no', $request->input("matric_no"))->exists()) {
            return redirect()->back()->with('error', 'You have already registered.');
        }

        // Register user
        User::create([
            'name' => $request->input ("name"),
            'email' => $request->input ("email"),
            'matric_no' => $request->input ("matric_no"),
            'password' => Hash::make($request->input ("password")),
        ]);

        return redirect()->back()->with('success', 'Registration successful!');
    }
} 
