<?php

Route::post('dropzoner/upload', ['as' => 'dropzoner.upload', 'uses' => 'DropzonerController@postUpload'])->middleware('auth');
Route::post('dropzoner/delete', ['as' => 'dropzoner.delete', 'uses' => 'DropzonerController@postDelete'])->middleware('auth');
