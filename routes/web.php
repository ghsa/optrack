<?php

use App\Jobs\UpdateStockOptionsJob;
use App\Models\Stock;
use App\Models\User;
use App\Repositories\StockRepositories;
use App\Scopes\UserScope;
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

Route::get('/updateStocks', function () {
    app(StockRepositories::class)->updateAllStocks();
});

Route::get('/test', function () {
    $user = User::first();
    app(StockTrackerInterface::class)->getAccessToken($user);
    $stock = Stock::withoutGlobalScope(UserScope::class)->first();
    $info = app(StockTrackerInterface::class)->getStock($stock);
});

Route::get('/', 'AuthController@index')->name('login');
Route::post('singin', 'AuthController@signIn')->name('auth.signin');
Route::get('firstUser', 'AuthController@firstUser');

Route::group(['prefix' => '', 'middleware' => 'auth', 'as' => 'dashboard.'], function () {

    Route::get('home', 'HomeController@index')->name('home');
    Route::get('singout', 'AuthController@signOut')->name('auth.signout');
    Route::get('op-simulator/{id}', 'OpSimulatorController@simulator')->name('opSimulator');

    // Options
    Route::group(['prefix' => 'option', 'as' => 'option.'], function () {
        Route::get('/', 'OptionController@index')->name('index');
        Route::get('/show/{id}', 'OptionController@show')->name('show');
    });

    // UserOption
    Route::group(['prefix' => 'userOption', 'as' => 'userOption.'], function () {
        Route::get('/', 'UserOptionController@index')->name('index');
        Route::get('/show/{id}', 'UserOptionController@show')->name('show');
        Route::post('/', 'UserOptionController@index')->name('search');
        Route::put('/{id}', 'UserOptionController@update')->name('update');
        Route::get('/create', 'UserOptionController@create')->name('create');
        Route::post('/store', 'UserOptionController@store')->name('store');
        Route::delete('/destroy/{id}', 'UserOptionController@destroy')->name('destroy');
    });

    // UserStocks
    Route::group(['prefix' => 'userStock', 'as' => 'userStock.'], function () {
        Route::get('/', 'UserStockController@index')->name('index');
        Route::get('/show/{id}', 'UserStockController@show')->name('show');
        Route::post('/', 'UserStockController@index')->name('search');
        Route::put('/{id}', 'UserStockController@update')->name('update');
        Route::get('/create', 'UserStockController@create')->name('create');
        Route::post('/store', 'UserStockController@store')->name('store');
        Route::delete('/destroy/{id}', 'UserStockController@destroy')->name('destroy');
    });

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
