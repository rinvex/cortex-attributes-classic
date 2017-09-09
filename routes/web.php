<?php

declare(strict_types=1);

Route::group(['domain' => domain()], function () {

    Route::name('adminarea.')
         ->namespace('Cortex\Attributes\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-dashboard'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/adminarea' : 'adminarea')->group(function () {

        // Attributes Routes
        Route::name('attributes.')->prefix('attributes')->group(function () {
            Route::get('/')->name('index')->uses('AttributesController@index');
            Route::get('create')->name('create')->uses('AttributesController@form');
            Route::post('create')->name('store')->uses('AttributesController@store');
            Route::get('{attribute}')->name('edit')->uses('AttributesController@form');
            Route::put('{attribute}')->name('update')->uses('AttributesController@update');
            Route::get('{attribute}/logs')->name('logs')->uses('AttributesController@logs');
            Route::delete('{attribute}')->name('delete')->uses('AttributesController@delete');
        });

    });

});
