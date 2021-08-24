<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//books api

Route::get('/books/list','ApiBookController@listBooks');


Route::get('/books/show/{id}','ApiBookController@showBook');

Route::middleware('isApiUser')->group(function (){

    Route::get('books/delete/{id}','ApiBookController@deleteBook');

    Route::post('books/add','ApiBookController@addBook');

    Route::post('books/update/{id}','ApiBookController@updateBook');
});




//Token-Based Authentication

Route::post('handle-login','ApiAuthController@handleLogin');


Route::post('handle-register','ApiAuthController@handleRegister');


Route::post('logout','ApiAuthController@logout');



