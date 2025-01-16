<?php

use App\Domain\Product\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
#use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group([
    'prefix' => 'products',
    'as' => 'products.',
    'middleware' => ['web'],
], function () {
    
    Route::get('show', [ProductController::class, 'show'])->name('show');          //dettaglio del singolo prodotto
    Route::put('store', [ProductController::class, 'store'])->name('store');        //salvataggio del nuovo prodotto creato
    Route::post('update', [ProductController::class, 'update'])->name('update');    //aggiornamento di un prodotto
    Route::delete('delete', [ProductController::class, 'destroy'])->name('delete'); //cancellazione di un prodotto
    Route::get('find', [ProductController::class, 'find'])->name('find');           //ricerca di prodotti
});


Route::group([
    'prefix' => 'orders',
    'as' => 'orders.',
    'middleware' => ['web'],
], function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::get('order', [OrderController::class, 'index'])->name('show');
    Route::get('create', [OrderController::class, 'create'])->name('create');
    Route::put('store', [OrderController::class, 'store'])->name('store');
    Route::get('edit', [OrderController::class, 'update'])->name('edit');
    Route::post('update', [OrderController::class, 'update'])->name('update');
    Route::delete('delete', [OrderController::class, 'destroy'])->name('delete');
    Route::get('find', [OrderController::class, 'find'])->name('find');
});