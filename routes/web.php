<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//Subscriber
Route::post('subscriber', 'SubscriberController@store')->name('subscriber.store');

//All Post View FrontEnd
Route::get('posts', 'PostController@index')->name('post.index');

//Single Post View FrontEnd
Route::get('post/{slug}', 'PostController@details')->name('post.details');

//Post By Category  View FrontEnd
Route::get('category/{slug}', 'PostController@postByCategory')->name('category.posts');

//Post By Tags View FrontEnd
Route::get('tag/{slug}', 'PostController@postByTag')->name('tag.posts');



//Default Auth Routes
Route::group(['middleware' => ['auth']],
    function () {
        Route::post('favorite/{post}/add', 'FavoriteController@add')->name('post.favorite');

        Route::post('comment/{post}', 'CommentController@store')->name('comment.store');
    });


//Admin Routes
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']],
    function () {

        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('tag', 'TagController');
        Route::resource('category', 'CategoryController');
        Route::resource('post', 'PostController');

        //Setting
        Route::get('settings', 'SettingsController@index')->name('settings');
        Route::put('profile-update', 'SettingsController@updateProfile')->name('profile.update');
        Route::put('password-update', 'SettingsController@updatePassword')->name('password.update');

        //Favorite
        Route::get('/favorite', 'FavoriteController@index')->name('favorite.index');

        //Pending+Approval
        Route::get('/pending/post', 'PostController@pending')->name('post.pending');
        Route::put('/post/{id}/approve', 'PostController@approval')->name('post.approve');

        //Subscriber
        Route::get('/subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::delete('/subscriber/{subscriber}', 'SubscriberController@destroy')->name('subscriber.destroy');

        //Comment
        Route::get('comments', 'CommentController@index')->name('comment.index');
        Route::delete('comments/{id}', 'CommentController@destroy')->name('comment.destroy');

    });

//Author Routes
Route::group(['as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']],
    function () {

        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('post', 'PostController');

        //Favorite
        Route::get('/favorite', 'FavoriteController@index')->name('favorite.index');

        //Setting
        Route::get('settings', 'SettingsController@index')->name('settings');
        Route::put('profile-update', 'SettingsController@updateProfile')->name('profile.update');
        Route::put('password-update', 'SettingsController@updatePassword')->name('password.update');


        //Comment
        Route::get('comments', 'CommentController@index')->name('comment.index');
        Route::delete('comments/{id}', 'CommentController@destroy')->name('comment.destroy');

    });

