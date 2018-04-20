<?php 

Route::group(['middleware' => ['web']], function () {
	Route::get('/admin-panel/product-attr-items/{item?}', 'Modules\Eccommerce\Http\Controllers\InsertProductAttrItemsController@index')->name('product_attr');
	Route::post('/admin-panel/product-attr-items/{item?}', 'Modules\Eccommerce\Http\Controllers\InsertProductAttrItemsController@create')->name('product_attr_item_create');
	Route::patch('/admin-panel/product-attr-items/{item?}', 'Modules\Eccommerce\Http\Controllers\InsertProductAttrItemsController@datatable')->name('product_attr_items_datatable');
	Route::get('/admin-panel/product-attr-items/{item?}/edit', 'Modules\Eccommerce\Http\Controllers\InsertProductAttrItemsController@edit')->name('product_attr_items_edit');
	Route::put('/admin-panel/product-attr-items/{item?}/edit', 'Modules\Eccommerce\Http\Controllers\InsertProductAttrItemsController@update')->name('product_attr_items_update');
	Route::delete('/admin-panel/product-attr-items/{item?}', 'Modules\Eccommerce\Http\Controllers\InsertProductAttrItemsController@delete')->name('product_attr_items_delete');

});

