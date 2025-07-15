<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // show the signup page
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    // process signup
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6',
        ]);

        // Hash password before saving
        $data['password'] = Hash::make($data['password']);

        // Limit to 2 admins only
        if (Admin::count() >= 2) {
            return back()->with('error', 'Only 2 admins allowed.');
        }

        Admin::create($data);
        return redirect('/admin/login')->with('success', 'Admin registered successfully');
    }

    // show login page
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            session(['admin_logged_in' => true, 'admin_id' => $admin->id]);
            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Invalid login details');
    }

    // logout
    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id']);
        return redirect('/admin/login')->with('success', 'Logged out successfully');
    }
}
