<?php

use App\Http\Controllers\OrderController;
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
    'middleware' => ['web', 'auth', 'verified'],
], function () {
    Route::get('', [ProductController::class, 'index'])->name('index');             //lista di tutti i prodotti
    Route::get('create', [ProductController::class, 'create'])->name('create');     //form di creazione di un prodotto
    Route::put('store', [ProductController::class, 'store'])->name('store');        //salvataggio del nuovo prodotto creato
    Route::get('edit', [ProductController::class, 'edit'])->name('edit');           //form di modifica di un prodotto
    Route::post('update', [ProductController::class, 'update'])->name('update');    //aggiornamento di un prodotto
    Route::delete('delete', [ProductController::class, 'destroy'])->name('delete'); //cancellazione di un prodotto
    Route::get('find', [ProductController::class, 'find'])->name('find');           //ricerca di prodotti    
});

Route::group([
    'prefix' => 'orders',
    'as' => 'orders.',
    'middleware' => ['web', 'auth', 'verified'],
], function () {
    Route::get('', [OrderController::class, 'index'])->name('index');             //lista di tutti i prodotti
    Route::get('create', [OrderController::class, 'create'])->name('create');     //form di creazione di un ordine
    Route::put('buy', [OrderController::class, 'store'])->name('store');          //Creazione di un ordine
    Route::get('edit', [OrderController::class, 'edit'])->name('edit');           //form di modifica di un ordine
    Route::post('update', [OrderController::class, 'update'])->name('update');    //aggiornamento di un ordine
    Route::delete('delete', [OrderController::class, 'destroy'])->name('delete'); //cancellazione di un ordine
    Route::get('find', [OrderController::class, 'find'])->name('find');           //ricerca di ordini
});

require __DIR__.'/auth.php';
