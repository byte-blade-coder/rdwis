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
    // Agar koi sirf domain khole, to usy view-projects pe bhej do
    Route::get('/', function () {
        return redirect()->route('view-projects');
    });

    // --- Project Management Module ---

    // 1. View All Projects (Controller se data layega based on Unit)
    Route::get('/view-projects', [ProjectController::class, 'index'])->name('view-projects');

    // 2. Open Project Details (Specific ID ke sath)
    Route::get('/openprojectdetails/{id}', [ProjectController::class, 'show'])->name('projects.show');

    // 3. Create New Project Form Show Karna
    // (Hum isay Controller ke 'create' function pe bhej rahe hain, taake logic wahan likhi ja sake)
    Route::get('/addnewproject', [ProjectController::class, 'create'])->name('addnewproject');

    // 4. Save New Project (Jab form submit hoga)
    // (Ye route humne naya add kiya hai taake future mein data save ho sake)
    Route::post('/save-project', [ProjectController::class, 'store'])->name('save-project');


    // --- Project Sub-Features (Filhal Static Views) ---
    // Inko baad mein Controller se connect karenge jab inka logic likhenge

    Route::get('/addmilestonepr', function () {
        return view('projects.addmilestonepr');
    })->name('addmilestonepr');

    Route::get('/projecthistory', function () {
        return view('projects.projecthistory');
    })->name('projecthistory');

    Route::get('/gantchartpr', function () {
        return view('projects.gantchartpr');
    })->name('gantchartpr');

    Route::get('/openmprs', function () {
        return view('projects.openmprs');
    })->name('openmprs');

    Route::get('/viewmpr', function () {
        return view('projects.viewmpr');
    })->name('viewmpr');


    // --- Purchase Cases Module (PCs) ---

    Route::get('/createnewcase', function () {
        return view('purchase.new_case.createnewcase');
    })->name('createnewcase');

    Route::get('/purchasecasedetails', function () {
        return view('purchase.new_case.purchasecasedetails');
    })->name('purchasecasedetails');

    Route::get('/viewpurchasecase', function () {
        return view('purchase.new_case.viewpurchasecase');
    })->name('viewpurchasecase');

});