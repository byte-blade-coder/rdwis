<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone; // Ye zaroori hai
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // 1. Show All Projects (User ke Unit ke hisab se)
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Sirf wahi projects dikhao jo user ke Unit (Department) ke hain
        $projects = Project::where('prj_unt_id', $user->acc_unt_id)->get();

        return view('projects.viewprojects', compact('projects'));
    }

    // 2. Show Single Project Details
    public function show($id)
    {
        // Project ko uske Milestones ke sath load karo
        $project = Project::with('milestones')->where('prj_id', $id)->firstOrFail();
        
        return view('projects.openprojectdetails', compact('project'));
    }

    // ==========================================
    // NEW PROJECT FUNCTIONS (Ye Missing Thay)
    // ==========================================

    // 3. Show Form to Create New Project
    public function create()
    {
        return view('projects.addnewproject');
    }

   // 4. Save New Project to Database
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'prj_title' => 'required|string|max:255',
            'prj_propcost' => 'nullable|numeric',
        ]);

        // 1. Auto-generate Next Project ID
        $maxId = Project::max('prj_id');
        $nextId = $maxId ? $maxId + 1 : 1;

        // 2. Create Project Instance
        $project = new Project();
        $project->prj_id = $nextId;

        // --- ERROR FIX START ---
        // Puraana code: 'PRJ-' . $nextId; (10 chars - Too Long)
        // Naya code: 'P-' . $nextId; (8 chars - Fits perfectly)
        $project->prj_code = 'P-' . $nextId; 
        // --- ERROR FIX END ---

        $project->prj_title = $request->prj_title;
        $project->prj_scope = $request->prj_scope;
        $project->prj_propcost = $request->prj_propcost;
        $project->prj_status = 'Open';
        $project->prj_unt_id = Auth::user()->acc_unt_id;
        $project->prj_rcptdt = now();
        
        $project->save();

        // Redirect to Details Page
        return redirect()->route('projects.show', $project->prj_id)
                         ->with('success', 'Project created successfully!');
    }

    // ==========================================
    // MILESTONE FUNCTIONS
    // ==========================================

    // 5. Show Add Milestone Form
    public function createMilestone($id)
    {
        $project = Project::where('prj_id', $id)->firstOrFail();
        return view('projects.addmilestonepr', compact('project'));
    }

    // 6. Save Milestone Data
    public function storeMilestone(Request $request, $id)
    {
        $request->validate([
            'msn_desc' => 'required|string|max:255',
            'msn_targetdt' => 'required|date',
            'msn_type' => 'required|string',
            'msn_status' => 'required|string'
        ]);

        // Auto ID logic for Milestone
        $maxId = Milestone::max('msn_id');
        $nextId = $maxId ? $maxId + 1 : 1;

        $milestone = new Milestone();
        $milestone->msn_id = $nextId;
        $milestone->msn_xprj_id = $id;
        $milestone->msn_desc = $request->msn_desc;
        $milestone->msn_targetdt = $request->msn_targetdt;
        $milestone->msn_type = $request->msn_type;
        $milestone->msn_status = $request->msn_status;
        $milestone->save();

        return redirect()->route('projects.show', $id)
                         ->with('success', 'Milestone added successfully!');
    }
}