<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\PrgHistory; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; 

class ProjectController extends Controller
{
    // --- Projects ---
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        
        // Show projects only for user's unit
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
        // Connection name dynamic utha rahe hain
        $connection = config('database.default'); 
        
        $request->validate([
            'prj_code' => [
                'required', 
                'string', 
                'max:20', 
                Rule::unique("$connection.prj.projects", 'prj_code') 
            ],
            'prj_title' => 'required|string|max:255',
            'prj_sponsor' => 'nullable|string|max:255',
            'prj_propcost' => 'nullable|numeric',
        ]);

        // --- ID GENERATION LOGIC RESTORED (Zaroori hai) ---
        $maxId = Project::max('prj_id');
        $nextId = $maxId ? $maxId + 1 : 1;

        $project = new Project();
        $project->prj_id = $nextId; // <--- Ye line Wapis aa gayi
        $project->prj_code = $request->prj_code;
        $project->prj_title = $request->prj_title;
        $project->prj_sponsor = $request->prj_sponsor;
        $project->prj_scope = $request->prj_scope;
        $project->prj_propcost = $request->prj_propcost;
        $project->prj_status = 'Open';
        
        // Agar user login nahi hai to default ID use karega (Error bachane ke liye)
        $project->prj_unt_id = Auth::check() ? Auth::user()->acc_unt_id : 200000; 
        
        $project->prj_rcptdt = now();
        
        $project->save();

        return redirect()->route('projects.show', $project->prj_id)
                         ->with('success', 'Project created successfully! You can now add details.');
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

    public function editMilestone($id)
    {
        $milestone = Milestone::where('msn_id', $id)->firstOrFail();
        $project = Project::where('prj_id', $milestone->msn_xprj_id)->first();
        
        return view('projects.editmilestone', compact('milestone', 'project'));
    }

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
        
        $milestone->save();

        return redirect()->route('projects.show', $milestone->msn_xprj_id)
                         ->with('success', 'Milestone Updated Successfully!');
    }

    public function deleteMilestone($id)
    {
        $milestone = Milestone::where('msn_id', $id)->firstOrFail();
        $projectId = $milestone->msn_xprj_id;
        
        $milestone->delete();

        return redirect()->route('projects.show', $projectId)
                         ->with('success', 'Milestone Deleted Successfully!');
    }

    // --- MPR (Reports) ---
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
        
        // --- AUTHOR LOGIC ---
        // User ka Designation Short Code (e.g., "AD-IT") uthayega
        if (Auth::check()) {
            // Ensure User model has 'role' relationship defined
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

    // --- FINANCIAL SPENDINGS ---
    public function projectSpendings($id)
    {
        // 1. Project Basic Info
        $project = Project::where('prj_id', $id)->firstOrFail();

        // 2. TOTAL ALLOCATED BUDGET (From fin.msncosts)
        $totalBudget = DB::table('fin.msncosts')
            ->where('mct_prj_id', $id)
            ->sum('mct_cost');

        // 3. ACTUAL SPENDING (Specific Project Spendings)
        // Hum 'cmt_docid' use kar rahe hain jo Project ID store karta hai (Specific Project Logic)
        $totalSpent = DB::table('fin.transactions')
            ->join('fin.commitments', 'fin.transactions.trn_cmt_id', '=', 'fin.commitments.cmt_id')
            ->where('fin.commitments.cmt_docid', $id) // Specific Project ID check
            ->sum('fin.transactions.trn_amount1');

        // 4. BUDGET BREAKDOWN (Graph Data - Head Wise)
        $budgetBreakdown = DB::table('fin.msncosts')
            ->select('mct_hed_id', DB::raw('SUM(mct_cost) as total_cost'))
            ->where('mct_prj_id', $id)
            ->groupBy('mct_hed_id')
            ->get();

        // 5. Calculate Remaining
        $balance = $totalBudget - $totalSpent;
        $percentageSpent = $totalBudget > 0 ? round(($totalSpent / $totalBudget) * 100, 1) : 0;

        // Charts Data Preparation
        $chartLabels = $budgetBreakdown->pluck('mct_hed_id')->toArray();
        $chartData = $budgetBreakdown->pluck('total_cost')->toArray();

        return view('projects.spendings', compact(
            'project', 'totalBudget', 'totalSpent', 'balance', 'percentageSpent', 'chartLabels', 'chartData'
        ));
    }
}