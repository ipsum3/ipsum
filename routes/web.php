<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([],
    function() {

        Route::get('/', [
            \App\Http\Controllers\ArticleController::class, 'home'
        ])->name('home');


        Route::controller(\App\Http\Controllers\ContactController::class)->prefix('contact')->name('contact.')->group(
            function () {
                Route::get('', 'index')->name('index');
                Route::get('success', 'index')->name('success');
                Route::post('', 'send')->name('send');
            }
        );

        Route::controller(\App\Http\Controllers\ArticleController::class)->prefix('blog')->name('blog.')->group(
            function () {
                Route::get('', 'blogIndex')->name('index');
                Route::get('categorie/{slug}', 'blogCategorie')->name('category');
                Route::get('{article:slug}', 'blogDetail')->name('show');
            }
        );


        // Catch all route : à mettre en dernier
        Route::get('{slug}', [
            \App\Http\Controllers\ArticleController::class, 'index'
        ])->name('article');
    }
);
