<?php

Route::get('/', function () {
    return view('welcome');
})->name('home');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']],
    function () {

        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('tag', 'TagController');
        Route::resource('category', 'CategoryController');
        Route::resource('post', 'PostController');


        Route::get('post/{id}/pending', 'PostController@pendingPost')->name('post.pending');
        Route::put('post/{id}/approve', 'PostController@approvePost')->name('post.approve');
    });


Route::group(['as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']],
    function () {

        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('post', 'PostController');


    });

