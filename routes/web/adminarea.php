<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {
    Route::name('adminarea.')
         ->namespace('Cortex\Attributes\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Attributes Routes
             Route::name('attributes.')->prefix('attributes')->group(function () {
                 Route::get('/')->name('index')->uses('AttributesController@index');
                 Route::get('import')->name('import')->uses('AttributesController@import');
                 Route::post('import')->name('stash')->uses('AttributesController@stash');
                 Route::post('hoard')->name('hoard')->uses('AttributesController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('AttributesController@importLogs');
                 Route::get('create')->name('create')->uses('AttributesController@create');
                 Route::post('create')->name('store')->uses('AttributesController@store');
                 Route::get('{attribute}')->name('edit')->uses('AttributesController@edit');
                 Route::put('{attribute}')->name('update')->uses('AttributesController@update');
                 Route::get('{attribute}/logs')->name('logs')->uses('AttributesController@logs');
                 Route::delete('{attribute}')->name('destroy')->uses('AttributesController@destroy');
             });
         });
});
