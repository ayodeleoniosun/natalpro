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
    ['namespace' => 'App\Modules\V1\Controllers'],
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
                Route::get('/', 'AdminController@index')->name('admin.index');
                Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
                Route::post('/', 'AdminController@login')->name('admin.login');
                Route::get('/settings', 'AdminController@settings')->name('admin.settings.index');
                Route::post('/settings', 'AdminController@updateSettings')->name('admin.settings.update');
                Route::get('/logout', 'AdminController@logout')->name('admin.logout');
                
                //users
                Route::get('/users/{type?}', 'UserController@users')->name('admin.users.type');
                
                Route::group(
                    ['prefix' => 'vaccination'],
                    function () {
                        Route::get('/', 'VaccinationController@index')->name('admin.vaccination.index');
                        Route::get('/{id}', 'VaccinationController@show')->name('vaccination.show')->where('id', '[0-9]+');
                        Route::get('/sms-sample', 'VaccinationController@smsSample')->name('admin.vaccination.sms-sample.index');
                        Route::post('/sms-sample', 'VaccinationController@addSmsSample')->name('admin.vaccination.sms-sample.add');
                    }
                );
            }
        );
    }
);
