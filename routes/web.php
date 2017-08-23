<?php

declare(strict_types=1);

use Rinvex\Attributable\Contracts\AttributeContract;

Route::model('attribute', AttributeContract::class);

Route::group(['domain' => domain()], function () {

    Route::name('backend.')
         ->namespace('Cortex\Attributable\Http\Controllers\Backend')
         ->middleware(['web', 'nohttpcache', 'can:access-dashboard'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/backend' : 'backend')->group(function () {

        // Attributes Routes
        Route::name('attributes.')->prefix('attributes')->group(function () {
            Route::get('/')->name('index')->uses('AttributesController@index');
            Route::get('create')->name('create')->uses('AttributesController@form');
            Route::post('create')->name('store')->uses('AttributesController@store');
            Route::get('{attribute}')->name('edit')->uses('AttributesController@form')->where('attribute', '[0-9]+');
            Route::put('{attribute}')->name('update')->uses('AttributesController@update')->where('attribute', '[0-9]+');
            Route::get('{attribute}/logs')->name('logs')->uses('AttributesController@logs')->where('attribute', '[0-9]+');
            Route::delete('{attribute}')->name('delete')->uses('AttributesController@delete')->where('attribute', '[0-9]+');
        });

    });

});
