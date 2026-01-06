<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Yahan hum application ke saare routes register kar rahe hain.
|
*/

// ====================================================
// 1. GUEST ROUTES (Jo bina login ke dikhenge)
// ====================================================

// Login Page Show karna
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Login ka Data submit karna (POST request)
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout karna
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ====================================================
// 2. PROTECTED ROUTES (Jo sirf Login hone par dikhenge)
// ====================================================
Route::middleware('auth')->group(function () {

    // --- Dashboard Redirection ---
    // Rule 1: Agar koi sirf domain khole, to usy dashboard par bhej do
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Rule 2: Dashboard ka actual Route (Ye index.blade.php khol raha hai)
    Route::get('/dashboard', function () {
        return view('index'); 
    })->name('dashboard');


    // --- Project Management Module ---

    // 1. View All Projects (List)
    Route::get('/view-projects', [ProjectController::class, 'index'])->name('view-projects');

    // 2. Create New Project (Form Show)
    Route::get('/addnewproject', [ProjectController::class, 'create'])->name('addnewproject');

    // 3. Save New Project (Data Save)
    Route::post('/save-project', [ProjectController::class, 'store'])->name('save-project');

    // 4. Open Project Details (Specific Project ID ke sath)
    Route::get('/openprojectdetails/{id}', [ProjectController::class, 'show'])->name('projects.show');


    // --- Milestone Management (New Added) ---

    // 1. Show Milestone Form (Project ID pass kar rahe hain)
    Route::get('/project/{id}/add-milestone', [ProjectController::class, 'createMilestone'])->name('projects.add-milestone');

    // 2. Save Milestone Data
    Route::post('/project/{id}/save-milestone', [ProjectController::class, 'storeMilestone'])->name('projects.store-milestone');


    // --- Project Sub-Features (Static Views) ---
    // Note: 'addmilestonepr' wala route hata diya hai kyunki ab hum dynamic route use kar rahe hain upar


    // --- MPR (Monthly Progress Report) Modules ---

// 1. Prepare MPR Form (Is project ke liye MPR banao)
Route::get('/project/{id}/prepare-mpr', [ProjectController::class, 'prepareMpr'])->name('projects.prepare-mpr');

// 2. Save MPR Data
Route::post('/project/{id}/save-mpr', [ProjectController::class, 'storeMpr'])->name('projects.store-mpr');

// 3. View Specific MPR (History ID ke base par)
Route::get('/view-mpr/{mpr_id}', [ProjectController::class, 'viewMpr'])->name('projects.view-mpr');


    
    Route::get('/projecthistory', function () {
        return view('projects.projecthistory');
    })->name('projecthistory');

    Route::get('/gantchartpr', function () {
        return view('projects.gantchartpr');
    })->name('gantchartpr');

    // Route::get('/openmprs', function () {
    //     return view('projects.openmprs');
    // })->name('openmprs');

    // Route::get('/viewmpr', function () {
    //     return view('projects.viewmpr');
    // })->name('viewmpr');


    Route::get('/createnewcase', function () {
        return view('purchase.new_case.createnewcase');
    })->name('createnewcase');

    Route::get('/purchasecasedetails', function () {
        return view('purchase.new_case.purchasecasedetails');
    })->name('purchasecasedetails');

    Route::get('/viewpurchasecase', function () {
        return view('purchase.new_case.viewpurchasecase');
    })->name('viewpurchasecase');

    Route::get('/minute-sheet', function () {
        return view('purchase.new_case.minutesheet');
    })->name('minutesheet');

    Route::get('/print-minute', function () {
        return view('purchase.new_case.print_minute');
    })->name('purchase.new_case.print_minute');


});