<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\PrgHistory; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 

class ProjectController extends Controller
{
    // --- Projects ---
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        $projects = Project::where('prj_unt_id', $user->acc_unt_id)->get();
        return view('projects.viewprojects', compact('projects'));
    }

    public function show($id)
    {
        $project = Project::with('milestones')->where('prj_id', $id)->firstOrFail();
        return view('projects.openprojectdetails', compact('project'));
    }

    public function create()
    {
        return view('projects.addnewproject');
    }

  public function store(Request $request)
    {
        // FIX: Connection name dynamic utha rahe hain taaki 'prj' ko connection na samjhay
        $connection = config('database.default'); // e.g. 'pgsql'
        
        $request->validate([
            'prj_code' => [
                'required', 
                'string', 
                'max:20', 
                // Ab ye ban jayega: unique:pgsql.prj.projects,prj_code
                Rule::unique("$connection.prj.projects", 'prj_code') 
            ],
            'prj_title' => 'required|string|max:255',
            'prj_sponsor' => 'nullable|string|max:255',
            'prj_propcost' => 'nullable|numeric',
        ]);

        // Auto-generate ID
        $maxId = Project::max('prj_id');
        $nextId = $maxId ? $maxId + 1 : 1;

        $project = new Project();
        $project->prj_id = $nextId;
        $project->prj_code = $request->prj_code;
        $project->prj_title = $request->prj_title;
        $project->prj_sponsor = $request->prj_sponsor;
        $project->prj_scope = $request->prj_scope;
        $project->prj_propcost = $request->prj_propcost;
        $project->prj_status = 'Open';
        $project->prj_unt_id = Auth::user()->acc_unt_id;
        $project->prj_rcptdt = now();
        
        $project->save();

        return redirect()->route('projects.show', $project->prj_id)
                         ->with('success', 'Project created successfully!');
    }
    
    // --- Milestones ---
    public function createMilestone($id)
    {
        $project = Project::where('prj_id', $id)->firstOrFail();
        return view('projects.addmilestonepr', compact('project'));
    }

    public function storeMilestone(Request $request, $id)
    {
        $request->validate([
            'msn_desc' => 'required',
            'msn_targetdt' => 'required|date',
            'msn_type' => 'required',
            'msn_status' => 'required'
        ]);

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

        return redirect()->route('projects.show', $id)->with('success', 'Milestone Added!');
    }

    // --- MPR (Reports) ---
    
    // Step 1: List Projects for MPR
    public function mprProjectList()
    {
        $user = Auth::user();
        $projects = Project::where('prj_unt_id', $user->acc_unt_id)->get();
        return view('projects.openmprs', compact('projects'));
    }

public function mprProjectView($id)
    {
        $project = Project::where('prj_id', $id)->firstOrFail();
        
        // 1. Get ALL History ordered by date desc (Recent first)
        $mprHistory = PrgHistory::where('pgh_xprj_id', $id)
                                ->orderBy('pgh_dtg', 'desc')
                                ->get();

        // 2. Get Current Active Milestone (Pending or In Progress, sorted by date)
        $currentMilestone = Milestone::where('msn_xprj_id', $id)
                                     ->whereIn('msn_status', ['Pending', 'In Progress'])
                                     ->orderBy('msn_targetdt', 'asc')
                                     ->first();

        return view('projects.viewmpr', compact('project', 'mprHistory', 'currentMilestone'));
    }

   public function storeMpr(Request $request, $id)
    {
        $request->validate([
            'pgh_dtg' => 'required|date',
            'pgh_progress' => 'required|string',
        ]);

        $mpr = new PrgHistory();
        $mpr->pgh_xprj_id = $id;
        $mpr->pgh_dtg = $request->pgh_dtg;
        $mpr->pgh_progress = $request->pgh_progress;
        
        // LOGIC CHANGE: Ab hum Author mein Designation Short Code save karenge
        if (Auth::check()) {
            // Agar Role exist karta hai to Short Desig uthao, warna Username
            $author = Auth::user()->role->rol_desigshort ?? Auth::user()->acc_username;
            $mpr->pgh_author = $author;
            $mpr->pgh_level = Auth::user()->acc_level;
        } else {
            $mpr->pgh_author = 'System';
            $mpr->pgh_level = 1;
        }

        $mpr->pgh_status = 'Submitted';
        $mpr->pgh_underedit = true; 
        
        $mpr->save();

        return redirect()->route('mpr.view', $id)->with('success', 'Progress Report Added Successfully!');
    }



    public function editMilestone($id)
    {
        $milestone = Milestone::where('msn_id', $id)->firstOrFail();
        // Project details bhi chahiye hongi wapis jane ke liye
        $project = Project::where('prj_id', $milestone->msn_xprj_id)->first();
        
        return view('projects.editmilestone', compact('milestone', 'project'));
    }

    // 2. Updated Data Save Karna
    public function updateMilestone(Request $request, $id)
    {
        $request->validate([
            'msn_desc' => 'required',
            'msn_targetdt' => 'required|date',
            'msn_type' => 'required',
            'msn_status' => 'required'
        ]);

        $milestone = Milestone::where('msn_id', $id)->firstOrFail();
        
        $milestone->msn_desc = $request->msn_desc;
        $milestone->msn_targetdt = $request->msn_targetdt;
        $milestone->msn_type = $request->msn_type;
        $milestone->msn_status = $request->msn_status;
        
        $milestone->save(); // Laravel automatically update query chalayega

        return redirect()->route('projects.show', $milestone->msn_xprj_id)
                         ->with('success', 'Milestone Updated Successfully!');
    }

    // 3. Delete Karna
    public function deleteMilestone($id)
    {
        $milestone = Milestone::where('msn_id', $id)->firstOrFail();
        $projectId = $milestone->msn_xprj_id; // Project ID save kar lo wapis jane ke liye
        
        $milestone->delete();

        return redirect()->route('projects.show', $projectId)
                         ->with('success', 'Milestone Deleted Successfully!');
    }


    
}