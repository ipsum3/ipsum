<?php

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
Auth::routes();

Route::group(
    [
        'namespace' => '\App\Http\Controllers',
    ],
    function() {
        Route::get('/', [
            'as' => 'home',
            'uses' => 'ArticleController@home'
        ]);


        Route::group(
            array(
                'prefix' => 'contact',
            ),
            function () {
                Route::get('', [
                    'as'     => 'contact.index',
                    'uses' => 'ContactController@index'
                ]);
                Route::get('success', array(
                    'as'     => 'contact.success',
                    'uses' => 'ContactController@success'
                ));
                Route::post('', array(
                    'as'     => 'contact.send',
                    'uses' => 'ContactController@send'
                ));
            }
        );


        Route::group(
            array(
                'prefix' => 'blog',
            ),
            function () {
                Route::get('', array(
                    'as'     => 'blog.index',
                    'uses' => 'ArticleController@blogIndex'
                ));
                Route::get('categorie/{slug}', array(
                    'as'     => 'blog.category',
                    'uses' => 'ArticleController@blogCategorie'
                ));
                Route::get('{slug}', array(
                    'as'     => 'blog.show',
                    'uses' => 'ArticleController@blogDetail'
                ));
            }
        );


        // Catch all route : à mettre en dernier
        Route::get('{slug}', array(
            'as'     => 'article',
            'uses' => 'ArticleController@index'
        ));
    }
);

include('admin.php');