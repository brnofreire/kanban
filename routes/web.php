<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return redirect()->route('boards.index');
    })->name('home');

    // Board routes
    Route::resource('boards', BoardController::class);

    // Category routes
    Route::post('/boards/{board}/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/boards/{board}/categories/positions', [CategoryController::class, 'updatePositions'])->name('categories.positions');

    // Task routes
    Route::post('/categories/{category}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/move', [TaskController::class, 'move'])->name('tasks.move');
    Route::post('/categories/{category}/tasks/positions', [TaskController::class, 'updatePositions'])->name('tasks.positions');
});
