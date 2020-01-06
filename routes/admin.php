<?php

Route::group(
    [
        'middleware' => ['web'],
        'namespace' => '\App\Http\Controllers\Admin'
    ],
    function() {


        /*Route::group(
            [
                'prefix' => config('ipsum.admin.route_prefix').'/marque',
            ],
            function() {

                Route::get("", array(
                    "as" => "admin.marque.index",
                    "uses" => "MarqueController@index",
                ));
                Route::post("", array(
                    "as" => "admin.marque.store",
                    "uses" => "MarqueController@store",
                ));
                Route::get("create", array(
                    "as" => "admin.marque.create",
                    "uses" => "MarqueController@create",
                ));
                Route::any("{marque}/destroy", array(
                    "as" => "admin.marque.destroy",
                    "uses" => "MarqueController@destroy",
                ));
                Route::put("{marque}", array(
                    "as" => "admin.marque.update",
                    "uses" => "MarqueController@update",
                ));
                Route::get("{marque}/edit", array(
                    "as" => "admin.marque.edit",
                    "uses" => "MarqueController@edit",
                ));
            }
        );*/


    }
);