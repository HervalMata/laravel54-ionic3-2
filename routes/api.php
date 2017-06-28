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

ApiRoute::version('v1', function () {
    ApiRoute::get('test1', function () {
        //return \CodeFlix\Models\User::paginate();
        return "teste";
    });
});

ApiRoute::version('v2', function () {
    ApiRoute::get('test2', function () {
        //return \CodeFlix\Models\User::paginate();
        return "teste";
    });
});