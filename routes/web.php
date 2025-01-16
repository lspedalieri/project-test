<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


Route::group([
    'prefix' => 'products',
    'as' => 'products.',
    'middleware' => ['web'],
], function () {
    Route::get('', [ProductController::class, 'index'])->name('index');             //lista di tutti i prodotti
    Route::get('create', [ProductController::class, 'create'])->name('create');     //form di creazione di un prodotto
    Route::get('edit', [ProductController::class, 'update'])->name('edit');         //form di modifica di un prodotto
});

require __DIR__.'/auth.php';
