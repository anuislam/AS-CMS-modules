<?php 

namespace Modules\Eccommerce\Entities;
use DB;

/**
* Shipping 
*/
class Shipping
{
	static function zone(){
		return DB::table('shipping_zone');
	}
}