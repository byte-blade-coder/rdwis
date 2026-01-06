<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone; 
use Illuminate\Support\Facades\Auth;
use App\Models\PrgHistory;

class ProjectController extends Controller
{
    // 1. Show All Projects 
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        
        $projects = Project::where('prj_unt_id', $user->acc_unt_id)->get();

        return view('projects.viewprojects', compact('projects'));
    }

    // 2. Show Single Project Details
    public function show($id)
    {
       
        $project = Project::with('milestones')->where('prj_id', $id)->firstOrFail();
        
        return view('projects.openprojectdetails', compact('project'));
    }

   
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
            'prj_sponsor' => 'nullable|string|max:255', // Validation add ki
            'prj_propcost' => 'nullable|numeric',
        ]);

        // 1. Auto-generate Next Project ID
        $maxId = Project::max('prj_id');
        $nextId = $maxId ? $maxId + 1 : 1;

        // 2. Create Project Instance
        $project = new Project();
        $project->prj_id = $nextId;
        
        // Auto-generate Code (8 chars fix)
        $project->prj_code = 'P-' . $nextId; 

        $project->prj_title = $request->prj_title;
        $project->prj_sponsor = $request->prj_sponsor; // <--- YE LINE ADD KI HAI
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

    // 1. Show Prepare MPR Form
    public function prepareMpr($id)
    {
        $project = Project::where('prj_id', $id)->firstOrFail();
        
        // Pichla MPR check karein taaki user ko purana status dikha sakein
        $lastMpr = PrgHistory::where('pgh_xprj_id', $id)
                             ->orderBy('pgh_dt', 'desc')
                             ->first();

        return view('projects.openmprs', compact('project', 'lastMpr'));
    }

    // 2. Save MPR
    public function storeMpr(Request $request, $id)
    {
        $request->validate([
            'pgh_dt' => 'required|date',
            'pgh_percent' => 'required|integer|min:0|max:100',
            'pgh_intro' => 'required|string|max:255',
            'pgh_progress' => 'required|string',
        ]);

        // Auto ID Generation
        $maxId = PrgHistory::max('pgh_id');
        $nextId = $maxId ? $maxId + 1 : 1;

        $mpr = new PrgHistory();
        $mpr->pgh_id = $nextId;
        $mpr->pgh_xprj_id = $id;
        $mpr->pgh_dt = $request->pgh_dt; // Report Date
        $mpr->pgh_intro = $request->pgh_intro; // Title
        $mpr->pgh_progress = $request->pgh_progress; // Details
        $mpr->pgh_issues = $request->pgh_issues; // Issues
        $mpr->pgh_percent = $request->pgh_percent; // %
        $mpr->pgh_status = 'Submitted';
        
        $mpr->save();

        // Optional: Project ka main status update karna ho to
        // $project = Project::find($id);
        // $project->prj_status = 'Work in Progress';
        // $project->save();

        return redirect()->route('projects.show', $id)->with('success', 'Monthly Progress Report Saved!');
    }

    // 3. View Single MPR Details
    public function viewMpr($mpr_id)
    {
        $mpr = PrgHistory::with('project')->where('pgh_id', $mpr_id)->firstOrFail();
        return view('projects.viewmpr', compact('mpr'));
    }
}