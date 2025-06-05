<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/todo', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/task', [TaskController::class, 'show'])->name('task');
    Route::post('/create', [TaskController::class, 'create'])->name('create');
    Route::post('/edit/{id}', [TaskController::class, 'edit'])->name('edit');
    Route::post('/delete/{id}', [TaskController::class, 'delete'])->name('delete');
});

require __DIR__.'/auth.php';
