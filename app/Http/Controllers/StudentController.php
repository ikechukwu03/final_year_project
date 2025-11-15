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
            'matric_number' => 'required|string',
            'graduation_year' => 'required|string:9',
            'password' => 'required|string|min:6',
        ]);

        // Check if student exists in finalists (including graduation year)
        $finalist = Finalist::where('name', $request->input("name"))
            ->where('email', $request->input("email"))
            ->where('matric_number', $request->input("matric_number"))
            ->where('graduation_year', $request->input("graduation_year"))
            ->first();

        if (!$finalist) {
            return redirect()->back()->with('error', 'You are not listed as a finalist.');
        }

        // Check if user is already registered
        if (User::where('email', $request->input("email"))->orWhere('matric_number', $request->input("matric_number"))->exists()) {
            return redirect()->back()->with('error', 'You have already registered.');
        }

        // Register user
        User::create([
            'name' => $request->input("name"),
            'email' => $request->input("email"),
            'matric_number' => $request->input("matric_number"),
            'graduation_year' => $request->input("graduation_year"),
            'password' => Hash::make($request->input("password")),
        ]);

        return redirect()->back()->with('success', 'Registration successful!');
    }


    //student login/logout
    public function showLoginForm()
{
    return view('student.loginPage');
}

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'No account found with this email.');
    }

    if (!\Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Incorrect password.');
    }

    auth()->login($user);

    return redirect()->route('student.dashboard')->with('success', 'Login successful!');
}

public function logout()
{
    auth()->logout();
    return redirect()->route('student.login')->with('success', 'Logged out successfully.');
}


}
