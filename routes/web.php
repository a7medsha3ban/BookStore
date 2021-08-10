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


Route::middleware('isLogin')->group(function (){

    //route to controller function which returns all books
    Route::get('/books/list','BookController@list');

    //route to controller function which returns the book with the id
    Route::get('/books/show/{id}','BookController@show');

    //route to controller function which creates a form
    Route::get('/books/create','BookController@create');

    //route to controller function which add a new book
    Route::post('books/add','BookController@add');

    //route to controller function which edits a book
    Route::get('books/edit/{id}','BookController@edit');

    Route::post('books/update/{id}','BookController@update');

    //route to controller function which deletes a book
    Route::get('books/delete/{id}','BookController@delete');


    //route to controller function which returns all Categories
    Route::get('/categories/list','CategoryController@list');

    //route to controller function which returns the Category with the id
    Route::get('/categories/show/{id}','CategoryController@show');


    //route to controller function which creates a form
    Route::get('/categories/create','CategoryController@create');

    //route to controller function which add a new Category
    Route::post('categories/add','CategoryController@add');

    //route to controller function which edits a Category
    Route::get('categories/edit/{id}','CategoryController@edit');

    Route::post('categories/update/{id}','CategoryController@update');

    //route to controller function which deletes a Category
    Route::get('categories/delete/{id}','CategoryController@delete');

    // Route to logout
    Route::get('logout','AuthController@logout');


});




Route::middleware('isGuest')->group(function (){
    // Route to return registration form
    Route::get('register','AuthController@register');
// Route to handle registration
    Route::post('handle-register','AuthController@handleRegister');

// Route to return login form
    Route::get('login','AuthController@login');
// Route to handle login
    Route::post('handle-login','AuthController@handleLogin');

});
