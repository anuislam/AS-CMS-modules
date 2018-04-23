<?php 
namespace Modules\Workdiaryblog\Entities;
use DB;
/**
* 
*/
class utility 
{
	

	public function wdb_get_header_menu(int $menu_id = 0){
	  $menu_html = DB::table('menu_items')->where('menu_id', '=', (int)$menu_id)->orderBy('menu_order', 'asc')->get();	  
	  return (count($menu_html) > 0) ? $menu_html : false ;
	}

	static function work_get(){
		return DB::table('posts')->where('post_type', '=', 'work');
	}

}