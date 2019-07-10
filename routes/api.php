<?php

use Illuminate\Http\Request;

// API v1
Route::group(['prefix' => 'v1'], function (){

    Route::get('/fetch/feeds', 'API\FeedController@getAllWithUsers');

    Route::post('/login', 'API\UserAuthController@login');
    Route::post('/register', 'API\UserAuthController@register');

    Route::group(['middleware' => 'auth:api'], function (){

        // User-Routes
        Route::get('/me', 'API\UserAuthController@getCurrentUser');

        // RSS-Feed Endpoints
        Route::get('/feeds', 'API\FeedController@getAll');
        Route::post('/feeds', 'API\FeedController@insertNew');
        Route::delete('/feeds/{id}', 'API\FeedController@removeFeed')->where('id', '[0-9]+');

        // Category Endpoints
        Route::get('/categories', 'API\CategoryController@getAll');
        Route::post('/categories', 'API\CategoryController@insertNew');
        Route::delete('/categories/{id}', 'API\CategoryController@removeCategory')->where('id', '[0-9]+');
    });

});


// API 404 error
Route::any('/{any}', function (){
    return \App\Helpers\Error::new('Endpoint not defined');
})->where('any', '.*');