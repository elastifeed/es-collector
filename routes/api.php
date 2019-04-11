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

Route::group(['prefix' => 'v1'], function (){

    Route::post('/login', 'API\UserAuthController@login');
    Route::post('/register', 'API\UserAuthController@register');

    Route::group(['middleware' => 'auth:api'], function (){
        Route::get('/me', 'API\UserAuthController@getCurrentUser');
    });

});

Route::any('/{any}', function (){
    return \App\Helpers\Error::new('Page not found');
})->where('any', '.*');

//Route::post('login', 'API\UserAuthController@login');
//Route::post('login', 'API\UserAuthController@login');