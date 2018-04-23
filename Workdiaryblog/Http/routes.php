<?php

Route::group(['middleware' => 'web'], function()
{
    Route::get('/', 'Modules\Workdiaryblog\Http\Controllers\WorkdiaryblogController@index');
    Route::get('/home', 'Modules\Workdiaryblog\Http\Controllers\WorkdiaryblogController@index');
});
