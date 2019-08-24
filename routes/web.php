<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//Subscriber
Route::post('subscriber', 'SubscriberController@store')->name('subscriber.store');


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']],
    function () {

        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('tag', 'TagController');
        Route::resource('category', 'CategoryController');
        Route::resource('post', 'PostController');


        Route::get('settings', 'SettingsController@index')->name('settings');
        Route::put('profile-update', 'SettingsController@updateProfile')->name('profile.update');
        Route::put('password-update', 'SettingsController@updatePassword')->name('password.update');


        Route::get('/pending/post', 'PostController@pending')->name('post.pending');
        Route::put('/post/{id}/approve', 'PostController@approval')->name('post.approve');

        Route::get('/subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::delete('/subscriber/{subscriber}', 'SubscriberController@destroy')->name('subscriber.destroy');

    });


Route::group(['as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']],
    function () {

        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('post', 'PostController');



        Route::get('settings', 'SettingsController@index')->name('settings');
        Route::put('profile-update', 'SettingsController@updateProfile')->name('profile.update');
        Route::put('password-update', 'SettingsController@updatePassword')->name('password.update');


    });

