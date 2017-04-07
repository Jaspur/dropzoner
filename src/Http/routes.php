<?php

Route::post('dropzoner/upload', ['as' => 'dropzoner.upload', 'uses' => 'DropzonerController@postUpload']);
Route::post('dropzoner/delete', ['as' => 'dropzoner.delete', 'uses' => 'DropzonerController@postDelete']);
