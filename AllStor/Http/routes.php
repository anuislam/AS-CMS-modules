<?php

Route::group(['middleware' => ['web'], 'namespace' => 'Modules\AllStor\Http\Controllers'], function()
{

	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');
      
});





