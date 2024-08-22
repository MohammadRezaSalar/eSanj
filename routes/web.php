<?php

use Illuminate\Support\Facades\Route;



Auth::routes(['register'=>false]);

Route::redirect('/', '/admin/welcome');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('/admin/')->group(function (){
    Route::view('welcome','admin.welcome');
    Route::view('tasks','admin.tasks.manage-tasks');
});

