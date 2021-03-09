<?php

/*
 * CMS Pages Management
 */
Route::group(['namespace' => 'Languages'], function () {
    Route::resource('languages', 'LanguagesController', ['except' => ['show']]);

});
