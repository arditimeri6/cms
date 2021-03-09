<?php

/*
 * CMS Pages Management
 */
Route::group(['namespace' => 'Themes'], function () {
    Route::resource('themes', 'ThemesController', ['except' => ['show']]);

});
