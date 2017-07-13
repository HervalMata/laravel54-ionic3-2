<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::get('/test', function () {
    //return ['message' => 'JSON criado com sucesso'];
    return \CodeFlix\Models\User::all();
});
*/

//Client - eh a app
ApiRoute::version('v1', function () {
//    ApiRoute::get('test1', function () {
//        //return \CodeFlix\Models\User::paginate();
//        return "teste";
//    });

    ApiRoute::group([
        'namespace'=> 'CodeFlix\Http\Controllers\Api',
        'as' => 'api'
    ], function (){
        //aula rate limiting
        ApiRoute::post('/access_token', [
            'uses' => 'AuthController@accessToken',
            'middleware' => 'api.throttle',
            'limit' => 10,
            'expires' => 1
        ])->name('.access_token');

//        ApiRoute::get('/test1', function () {
//            return "teste";
//        });

        //grupo
        ApiRoute::group([
            'middleware' => ['api.throttle', 'api.auth'],
            'limit' => 100,
            'expires' => 3
        ], function (){
            ApiRoute::post('/logout', 'AuthController@logout');
            //endpoints que irao precisar de autenticacao
            ApiRoute::get('/test', function () {
                return "Autenticacao realizada com sucesso!";
            });
        });

    });

});

//ApiRoute::version('v2', function () {
//    ApiRoute::get('test2', function () {
//        //return \CodeFlix\Models\User::paginate();
//        return "teste";
//    });
//});