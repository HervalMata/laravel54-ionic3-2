<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rota Principal
Route::get('/', function () {
    return view('welcome');
});

//Rotas para autenticação que o laravel já fornece - Aula 19
//Auth::routes(); Aula 23 desabilita

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')
    ->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')
    ->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')
    ->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//UserVerification
Route::get('email-verification/error', 'EmailVerificationController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'EmailVerificationController@getVerification')->name('email-verification.check');

//Rota Home para users logado
//Route::get('/home', 'HomeController@index');

//Rotas para users administrativos - Aula 20
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin\\'
], function () {
    Route::name('login')->get('login', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login');

    Route::group(['middleware' => ['isVerified', 'can:admin']], function () {
        Route::name('logout')->post('logout', 'Auth\LoginController@logout');
        Route::get('/dashboard', function () {
            //return "Área Administrativa funcionando";
            return view('admin.dashboard');
        });
        Route::resource('users', 'UserController');
        Route::name('change.password')
            ->get('/change/password', 'UserController@showPasswordForm');
        Route::name('update.password')
            ->put('update/password/{id}', 'UserController@updatePassword');
    });
});

//Rota para forçar login user
Route::get('/force-login', function () {
    \Auth::loginUsingId(1);
});

//Rotas úteis para o develop
Route::get('routes', function () {
    \Artisan::call('route:list');
    return "<pre>" . \Artisan::output();
});