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
    return view('auth.login');
});

Auth::routes();

Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('books/{id}', 'BookController@shows');
        Route::post('books/{id}', 'BookController@updates')->middleware('user');
        Route::get('list_author', 'BookController@author')->name('list_author');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::resource('book', BookController::class);
        Route::resource('user', UserController::class)->middleware('user');;
        Route::resource('author', AuthorController::class);
    }
);
