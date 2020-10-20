<?php

use App\Jobs\UpdateStockOptionsJob;
use App\Models\Stock;
use App\Models\User;
use App\Services\OplabService;
use App\Services\StockTrackerInterface;
use Illuminate\Support\Facades\Route;

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

Route::get('/testJob', function () {
    $stock = Stock::first();
    app(StockTrackerInterface::class)->getAccessToken($stock->user);
    dispatch(new UpdateStockOptionsJob($stock));
});

Route::get('/test', function () {
    $user = User::first();
    app(StockTrackerInterface::class)->getAccessToken($user);
    $info = app(StockTrackerInterface::class)->getStock($user, 'COGN3');
    dd($info);
});

Route::get('login', 'AuthController@index')->name('login');
Route::post('singin', 'AuthController@signIn')->name('auth.signin');
Route::get('firstUser', 'AuthController@firstUser');

Route::group(['prefix' => '', 'middleware' => 'auth', 'as' => 'dashboard.'], function () {

    Route::get('home', 'HomeController@index')->name('home');
    Route::get('singout', 'AuthController@signOut')->name('auth.signout');

    // Stocks
    Route::group(['prefix' => 'stock', 'as' => 'stock.'], function () {
        Route::get('/', 'StockController@index')->name('index');
        Route::get('/show/{id}', 'StockController@show')->name('show');
        Route::post('/', 'StockController@index')->name('search');
        Route::put('/{id}', 'StockController@update')->name('update');
        Route::get('/create', 'StockController@create')->name('create');
        Route::post('/store', 'StockController@store')->name('store');
        Route::delete('/destroy/{id}', 'StockController@destroy')->name('destroy');
    });
});
