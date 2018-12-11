<?php


Route::resource('user', 'UserController')->middleware('cors');
Route::get('/user/{user}/articles', 'UserController@getArticles')->middleware('cors');
Route::resource('article', 'ArticleController')->middleware('cors');
Route::get('/auth', 'UserController@getAuth')->middleware('cors');
