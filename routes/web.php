<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController; // <-- Ye line sabse zyada zaroori hai!

// Master Route
Route::get('/', function () {
    return view('index');
})->name('index');


// --- Project Module Routes ---

// 1. View All Projects (Ye ab Controller ke index method par jayega)
Route::get('/viewprojects', [ProjectController::class, 'index'])->name('viewprojects');

// 2. Project Details (Yahan '{id}' lagaya hai taaki specific project ka data mile)
// Example URL: /openprojectdetails/1
Route::get('/openprojectdetails/{id}', [ProjectController::class, 'show'])->name('projects.show');

// 3. Create New Project Page (Filhal static hai, baad mein iska bhi controller banega)
Route::get('/addnewproject', function () {
    return view('projects.addnewproject');
})->name('addnewproject');


// --- Other Static Pages (Filhal aise hi rehne dein) ---

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

// Purchase Cases (PCs)

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