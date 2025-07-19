<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
        // Public View
    public function publicProjects(Request $request)
    {
        $projects = Project::with('finalist')
            ->when($request->year, fn($q) => $q->where('year', $request->year))
            ->when($request->topic, fn($q) => $q->where('project_title', 'like', "%{$request->topic}%"))
            ->when($request->author, fn($q) => $q->whereHas('finalist', fn($q2) => $q2->where('name', 'like', "%{$request->author}%")))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->latest()->get();

        return view('projects.public', compact('projects'));
    }

    // Admin View
    public function adminApprovedProjects(Request $request)
    {
        $projects = Project::with('finalist')
            ->when($request->year, fn($q) => $q->where('year', $request->year))
            ->when($request->topic, fn($q) => $q->where('project_title', 'like', "%{$request->topic}%"))
            ->when($request->author, fn($q) => $q->whereHas('finalist', fn($q2) => $q2->where('name', 'like', "%{$request->author}%")))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->latest()->get();

        return view('admin.approved-projects', compact('projects'));
    }
}
