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
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

//https://laravel.com/docs/5.5/routing
Route::get('/events','EventController@index'); // 1 Retrieve -> Llista completa -> Paginació
Route::get('/events/{event}','EventController@show');  // 2 Retrieve -> 1 recurs concret
Route::get('/events_alt/{id}','EventController@show1');  // 2 Retrieve -> 1 recurs concret


//Route::get('/events/{event}','EventController@show');  // 2 Retrieve -> 1 recurs concret

Route::resource('Patata','PatataController');