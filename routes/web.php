<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'prefix' => 'v1',
        'namespace' => 'App\Modules\V1\Controllers'
    ],
    function () {
        Route::group(
            ['prefix' => 'vaccination'],
            function () {
                Route::get('/', 'VaccinationController@add')->name('vaccination.add');
                Route::post('/request', 'VaccinationController@request')->name('vaccination.request');
            }
        );

        //admin routes
        Route::group(
            ['prefix' => 'admin'],
            function () {
                Route::post('/', 'AdminController@login')->name('admin.login');
                Route::get('/settings', 'AdminController@getSettings')->name('admin.settings.index');
                Route::post('/settings', 'AdminController@updateSettings')->name('admin.settings.update');
                        
                Route::group(
                    ['prefix' => 'vaccination'],
                    function () {
                        Route::post('/', 'VaccinationController@index')->name('vaccination.index');
                        Route::get('/sms-sample', 'VaccinationController@smsSample')->name('vaccination.sms-sample.index');
                        Route::post('/sms-sample', 'VaccinationController@addSmsSample')->name('vaccination.sms-sample.add');
                        Route::get('/{id}', 'VaccinationController@getVaccination')->name('vaccination.details')->where('id', '[0-9]+');
                    }
                );
            }
        );
    }
);
