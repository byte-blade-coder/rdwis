<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project; // Project Model ko import karna zaroori hai

class ProjectController extends Controller
{
    // 1. Saare Projects ki list dikhane ke liye
    public function index()
    {
        // DB se saare projects uthayein (Pagination ke sath acha rahega agar data zyada ho)
        $projects = Project::all(); 
        
        // Agar data bohot zyada hai to $projects = Project::paginate(10); use karein

        // View ko data pass karein
        return view('projects.viewprojects', compact('projects'));
    }

    // 2. Kisi ek Project ki details dekhne ke liye
    public function show($id)
    {
        // ID ke basis par project dhundein
        $project = Project::findOrFail($id); // Agar nahi mila to 404 error dega

        // View ko project object pass karein
        return view('projects.openprojectdetails', compact('project'));
    }
}
