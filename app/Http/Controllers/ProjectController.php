<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        // 1. Logged in user ko uthao
        $user = Auth::user();

        // 2. Check karo user kis Unit ka hai
        $userUnitId = $user->acc_unt_id;

        // 3. Sirf wahi Projects lao jinka prj_unt_id user ke unit id se match kare
        // Hum 'unit' relationship bhi load kar rahe hain taake view mein unit ka naam dikha sakein
        $projects = Project::where('prj_unt_id', $userUnitId)
                            ->with('unit') // Eager loading for performance
                            ->get();

        // 4. View ko data pass karo
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
