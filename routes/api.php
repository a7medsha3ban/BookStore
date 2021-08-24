<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//books api

Route::get('/books/list','ApiBookController@listBooks');


Route::get('/books/show/{id}','ApiBookController@showBook');


Route::get('books/delete/{id}','ApiBookController@deleteBook');


Route::post('books/add','ApiBookController@addBook');


Route::post('books/update/{id}','ApiBookController@updateBook');



