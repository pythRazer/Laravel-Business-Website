<?php

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

// Route::get('/', function () {
//     // return view('merchandise/listMerchandise');
//     return view('home');
// });
Route::get('/', 'HomeController@index');
// Route::get('/', 'MerchandiseController@merchandiseListPage');
Auth::routes();

Route::group(['prefix' => 'merchandise'], function(){
    Route::get('/', 'MerchandiseController@merchandiseListPage');
    Route::get('/create', 'MerchandiseController@merchandiseCreateProcess')->middleware(['user.auth.admin']);
    Route::get('/manage', 'MerchandiseController@merchandiseManageListPage')->middleware(['user.auth.admin']);

    Route::group(['prefix' => '{merchandise_id}'], function(){

        Route::get('/', 'MerchandiseController@merchandiseItemPage');

        Route::get('/edit', 'MerchandiseController@merchandiseItemEditPage');
        Route::put('/', 'MerchandiseController@merchandiseItemUpdateProcess');

        Route::get('/delete', 'MerchandiseController@merchandiseDelete')->middleware(['user.auth.admin']);

        Route::post('/buy', 'MerchandiseController@merchandiseItemBuyProcess')->middleware(['user.auth']);

    });
});

// Route::post('merchandise/{merchandise_id}/buy', 'MerchandiseController@merchandiseItemBuyProcess')->middleware(['user.auth']);

Route::get('/transaction', 'TransactionController@transactionListPage')->middleware(['user.auth']);
// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
