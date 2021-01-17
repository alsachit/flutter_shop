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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'user_is_admin'])->group( function (){

    //Units
    Route::get('units', 'UnitController@index')->name('units');

    //Categories
    Route::get('categories', 'CategoryController@index')->name('categories');

    //Products
    Route::get('products', 'ProductController@index')->name('products');

    //Tags
    Route::get('tags', 'TagController@index')->name('tags');

    //Countries
    Route::get('countries', 'CountryController@index')->name('countries');

    //States
    Route::get('states', 'StateController@index')->name('states');

    //Cities
    Route::get('cities', 'CityController@index')->name('cities');

    //Reviews
    Route::get('reviews', 'ReviewController@index')->name('reviews');

    //Tickets
    Route::get('tickets', 'TicketController@index')->name('tickets');

    //Roles
    Route::get('roles', 'RoleController@index')->name('roles');

});

