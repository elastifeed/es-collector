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

Route::get('/', function () {
    JavaScript::put([
        'routes' => [
            'push' => url('/api/v1/page'),
            'login' => url('/api/v1/login'),
            'profile' => url('/api/v1/me'),
            'proxy' => url('/api/v1/proxy'),
            'categories' => url('/api/v1/categories'),
            'feeds' => url('/api/v1/feeds'),

//            'target' => 'https://de.wikipedia.org/wiki/Weiler',
            'target' => 'https://www.welt.de/feeds/topnews.rss',
        ]
    ]);
    return view('push');
});
