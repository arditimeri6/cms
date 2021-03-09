<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

Route::post('/get/states', 'FrontendController@getStates')->name('get.states');
Route::post('/get/cities', 'FrontendController@getCities')->name('get.cities');

Route::post('/contacts', 'FrontendContactController@store')->name('contact');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        /*
         * User Dashboard Specific
         */
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        /*
         * User Account Specific
         */
        Route::get('account', 'AccountController@index')->name('account');

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', 'ProfileController@update')->name('profile.update');

        /*
         * User Profile Picture
         */
        Route::patch('profile-picture/update', 'ProfileController@updateProfilePicture')->name('profile-picture.update');
    });
});

Route::get('/', 'FrontendController@index')->name('index');
Route::group(['prefix' => \App\Localization::setLocale()], function () {
    /*
     * Show pages
     */
    Route::get('/blog', 'FrontendBlogController@index')->name('blog.index');
    Route::get('/blog/{blog?}', 'FrontendBlogController@blogPage')->name('blog.page');

    Route::get('/', 'FrontendController@index')->name('locale.index');
    Route::get('{slug}', 'FrontendController@showPage')->name('pages.show');
});
