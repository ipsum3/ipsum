<?php

use Illuminate\Support\Facades\Route;


Route::controller(\App\Http\Controllers\MarqueController::class)->prefix('marque')->name('admin.marque.')->group(
    function () {
        Route::get('', 'index')->name('index');
        Route::post('', 'store')->name('store');
        Route::get('create', 'create')->name('create');
        Route::any('{marque}/destroy', 'destroy')->name('destroy');
        Route::put('{marque}', 'update')->name('update');
        Route::get('{marque}/edit', 'edit')->name('edit');

    }
);

