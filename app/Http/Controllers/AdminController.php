<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Project;
use App\Models\Finalist;
use App\Models\Submission;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        ],[
        'email.unique' => 'This email is already used by another Admin. Please try a different one.',
        ]);


        // Hash password before saving
        $data['password'] = Hash::make($data['password']);

        // Limit to 2 admins only
        if (Admin::count() >= 2) {
            return back()->with('error', 'Only 2 admins allowed.');
        }

        Admin::create($data);
        return redirect('/admin/login')->with("success",'Registration successful! Please log in to continue.');
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


    //admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }


    // Show the upload form
    public function showUploadForm()
    {
        return view('admin.upload_finalists');
    }

    // Handle the upload of CSV file
    public function uploadFinalists(Request $request)
    {
        // Validate that a file is uploaded and it's a CSV
        $request->validate([
            'finalists_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        // Get the uploaded file
        $file = $request->file('finalists_file');

        // Open and read the CSV file
        if (($handle = fopen($file, 'r')) !== false) {
            $header = fgetcsv($handle); // Get the first row as header

            // Check for required columns
            if (!in_array('name', $header) || !in_array('matric_number', $header) || !in_array('email', $header) || !in_array('graduation_year', $header)) {
                return back()->with('error', 'CSV must have: name, matric_number, email, graduation_year');
            }

            // Loop through each row and insert into 'finalists' table
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                // Avoid duplicate entries
                $exists = DB::table('finalists')->where('matric_number', $data['matric_number'])->exists();
                if (!$exists) {
                    DB::table('finalists')->insert([
                        'name' => $data['name'],
                        'matric_number' => $data['matric_number'],
                        'email' => $data['email'],
                        'graduation_year' => $data['graduation_year'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            fclose($handle);

            return back()->with('success', 'Finalist list uploaded successfully.');
        }

        return back()->with('error', 'Failed to read file.');
    }



// Show all unapproved submissions
public function pendingProjects() {
    $submissions = Submission::with('finalist')->latest()->get();
    return view('admin.pending_projects', compact('submissions'));
}

// Approve a project
public function approveProject($id) {
    $submission = Submission::findOrFail($id);

    Project::create([
        'finalist_id' => $submission->finalist_id,
        'project_title' => $submission->project_title,
        'project_file' => $submission->project_file,
        'code_file' => $submission->code_file,
        'abstract' => $submission->abstract,
        'year' => $submission->finalist->graduation_year,
    ]);

    $submission->delete();

    return back()->with('success', 'Project approved and moved to public archive.');
}

// Reject a project
public function rejectProject($id) {
    $submission = Submission::findOrFail($id);
    $submission->delete();

    return back()->with('error', 'Project rejected and deleted.');
}



}


