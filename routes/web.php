<?php

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
        Route::get('/debug', function () {
            throw new Exception('My first Sentry error!');
        });

        Route::get('/', 'HomeController@index')->name('index');
        Route::get('/contact', 'HomeController@contactUs')->name('contact-us');
        Route::group(
            ['prefix' => 'vaccination'],
            function () {
                Route::name('vaccination.')->group(function () {
                    Route::get('/', 'VaccinationController@add')->name('add');
                    Route::get('/payment-success', 'VaccinationController@paymentSuccess')->name('payment-success');
                    Route::post('/request', 'VaccinationController@request')->name('request');
                });
            }
        );

        Route::group(
            ['prefix' => 'user'],
            function () {
                Route::name('user.')->group(function () {
                    Route::view('/', 'user.index')->name('index');
                    Route::post('/', 'UserController@login')->name('login');

                    Route::middleware(['check.user.login'])->group(function () {
                        Route::view('/change-password', 'user.change-password')->name('change-password.index');
                        Route::post('/change-password', 'UserController@changePassword')->name('change-password.update');
                        Route::get('/logout', 'UserController@logout')->name('logout');
                        
                        Route::group(
                            ['prefix' => 'vaccination'],
                            function () {
                                Route::get('/{userType}', 'VaccinationController@index')->name('vaccination.index')->where('userType', '[a-zA-Z]+');
                                Route::get('/{userType}/{id}', 'VaccinationController@show')->name('vaccination.show')->where('userType', '[a-zA-Z]+');
                                Route::get('/opt-out/{id}', 'VaccinationController@optOut')->name('vaccination.opt-out');
                            }
                        );
                    });
                });
            }
        );


        //admin routes
        Route::group(
            ['prefix' => 'admin'],
            function () {
                Route::name('admin.')->group(function () {
                    Route::view('/', 'admin.index')->name('index');
                    Route::post('/', 'AdminController@login')->name('login');
                    
                    Route::middleware(['check.admin.login'])->group(function () {
                        Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
                        Route::get('/settings', 'AdminController@settings')->name('settings.index');
                        Route::post('/settings', 'AdminController@updateSettings')->name('settings.update');
                        Route::get('/logout', 'AdminController@logout')->name('logout');
                        Route::view('/change-password', 'admin.change-password')->name('change-password.index');
                        Route::post('/change-password', 'AdminController@changePassword')->name('change-password.update');

                        //users
                        Route::get('/users/{id}', 'UserController@userProfile')->name('user.profile');
                        Route::get('/users/{type?}', 'UserController@users')->name('users.type');
                        
                        Route::group(
                            ['prefix' => 'vaccination'],
                            function () {
                                Route::name('vaccination.')->group(function () {
                                    Route::get('/{userType}', 'VaccinationController@index')->name('index')->where('userType', '[a-zA-Z]+');
                                    Route::get('/{userType}/{id}', 'VaccinationController@show')->name('show')->where('userType', '[a-zA-Z]+');
                                    Route::get('/sms-sample', 'VaccinationController@smsSamples')->name('sms-sample.index');
                                    Route::get('/sms-sample/{interval}', 'VaccinationController@viewSmsSamples')->name('sms-sample.show');
                                    Route::post('/sms-sample', 'VaccinationController@addSmsSample')->name('sms-sample.add');
                                });
                            }
                        );
                    });
                });
            }
        );
    }
);
