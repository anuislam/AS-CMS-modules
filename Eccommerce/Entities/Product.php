<?php

namespace Modules\Eccommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product {

    static function category(){
    	return DB::table('tarms')->where('tarm-type', '=', 'product-cat');
    }

    static function tag(){
    	return DB::table('tarms')->where('tarm-type', '=', 'product-tag');
    }

    static function attr(){
    	return DB::table('tarms')->where('tarm-type', '=', 'product-attr');
    }

    static function attr_items(){
    	return DB::table('product_attr');
    }

    static function attr_item_exists($item_id){
    	$data = DB::table('product_attr')->select('id')->where('id', '=', $item_id)->first();
    	return (count($data) == 1) ? true : false ;
    }
}
