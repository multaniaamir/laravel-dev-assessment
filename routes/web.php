<?php

use App\Http\Controllers\ProfileController;
use App\Models\JobVacancy;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $query = JobVacancy::with('skills')->latest();
    
    // Filter by title/keyword
    
    if ($title = request()->query('title')) {
        $query->where('title', 'like', '%' . $title . '%')
              ->orWhere('description', 'like', '%' . $title . '%');
    }

    // Filter by location
    if ($location = request()->query('location')) {
        $query->where('location', 'like', '%' . $location . '%');
    }
    
    $jobs = $query->get();

    return Inertia::render('Dashboard', [
        'jobs' => $jobs,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
