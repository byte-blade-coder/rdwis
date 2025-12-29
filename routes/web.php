<?php

use Illuminate\Support\Facades\Route;


//master 
Route::get('/', function () {
    return view('index');
})->name('index');


//for open projects of div
Route::get('/viewopenproject', function () {
    return view('projects.open.viewopenproject');
})->name('viewopenproject');

Route::get('/openprojectdetails', function () {
    return view('projects.open.openprojectdetails');
})->name('openprojectdetails');

Route::get('/addmilestonepr', function () {
    return view('projects.open.addmilestonepr');
})->name('addmilestonepr');

//for close projects ofdiv
Route::get('/viewcloseproject', function () {
    return view('projects.close.viewcloseproject');
})->name('viewcloseproject');

Route::get('/closeprojectdetails', function () {
    return view('projects.close.closeprojectdetails');
})->name('closeprojectdetails');

Route::get('/addmilestonecpr', function () {
    return view('projects.close.addmilestonecpr');
})->name('addmilestonecpr');
