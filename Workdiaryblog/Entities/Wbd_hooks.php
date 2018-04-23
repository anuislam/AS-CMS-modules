<?php 
namespace Modules\Workdiaryblog\Entities;
use Html;
use Module;
/**
* Hooks
*/
class Wbd_hooks 
{
	
	function __construct(){
		$this->Wbd_register_func();
		add_action('not_found_page', [$this, 'Wbd_not_found_page_func']);
		add_action('site_header', [$this, 'Wbd_site_header_func']);
		add_action('site_footer', [$this, 'Wbd_site_footer_func']);
	}

	public function Wbd_register_func(){
		register_menu([
			'menu-title' 	 	=> 'Work Diary',
			'id' 	 		 	=> 'workdiary',
			'menu-icon' 	 	=> 'fa-pencil-square-o', 
			'capability' 	 	=> 'create_posts', 
			'menu_position' 	 	=> 105, 
		]);
			register_dropdown_menu('workdiary', [
				'menu-title' 	 	=> 'All Works',
				'id' 	 		 	=> 'all-works', //uniq
				'url' 	 		 	=> ['all-posts', 'work'], 
				'capability' 	 	=> 'read_others_post', 
			]);

			register_dropdown_menu('workdiary', [
				'menu-title' 	 	=> 'Add new work',
				'id' 	 		 	=> 'add-new-work', //uniq
				'url' 	 		 	=> ['create_post_type', 'work'], 
				'capability' 	 	=> 'create_posts', 
			]);

			register_dropdown_menu('workdiary', [
				'menu-title' 	 	=> 'Work category',
				'id' 	 		 	=> 'add-work-category', //uniq
				'url' 	 		 	=> ['create-tarms', 'work-category'], //route
				'capability' 	 	=> 'create_tarm', //uniq
			]);

			register_dropdown_menu('workdiary', [
				'menu-title' 	 	=> 'Work series',
				'id' 	 		 	=> 'work_series', //uniq
				'url' 	 		 	=> ['create-tarms', 'work-series'], //route
				'capability' 	 	=> 'manage_option', //uniq
			]);


		register_post_type([
			'id' 	 		 	=> 'work', //uniq
			'class' 	 	 	=> 'Modules\Workdiaryblog\Entities\work', //opject name
		]);


		register_tarm([
			'id' 	 		 	=> 'work-category', //uniq
			'class' 	 	 	=> 'Modules\Workdiaryblog\Entities\work_category',
		]);
		register_tarm([
			'id' 	 		 	=> 'work-series', //uniq
			'class' 	 	 	=> 'Modules\Workdiaryblog\Entities\work_series',
		]);

	//************************************************
	//crop image
	//************************************************

	crop_image_size([
		'name' 		=> 'slider_image', //must be give an uniq name
		'width' 	=> 400, 
		'height' 	=> 200,
		'resize' 	=> true,
	]);


	}

	public function Wbd_site_header_func(){
		echo Html::style(Module::asset('workdiaryblog:css/fonts.css'));
		echo Html::style(Module::asset('workdiaryblog:css/bootstrap.min.css'));
		echo Html::style(Module::asset('workdiaryblog:css/font-awesome.min.css'));
		echo Html::style(Module::asset('workdiaryblog:css/hexagons.min.css'));
		echo Html::style(Module::asset('workdiaryblog:css/monokai-sublime.css'));
		echo Html::style(Module::asset('workdiaryblog:css/jssocials.css'));
		echo Html::style(Module::asset('workdiaryblog:css/jssocials.css'));
		echo Html::style(Module::asset('workdiaryblog:css/jssocials-theme-flat.css'));
		echo Html::style(Module::asset('workdiaryblog:css/slicknav.min.css'));
		echo Html::style(Module::asset('workdiaryblog:css/owl.carousel.min.css'));
		echo Html::style(Module::asset('workdiaryblog:css/owl.theme.default.min.css'));
		echo Html::style(Module::asset('workdiaryblog:css/main.css'));
		echo Html::style(Module::asset('workdiaryblog:css/responsive.css'));
	}

	public function Wbd_site_footer_func(){
		echo Html::script(Module::asset('workdiaryblog:js').'/jquery-2.1.0.min.js', ['type' => 'text/javascript']);
		echo Html::script(Module::asset('workdiaryblog:js').'/hexagons.min.js', ['type' => 'text/javascript']);
		echo Html::script(Module::asset('workdiaryblog:js').'/jssocials.min.js', ['type' => 'text/javascript']);
		echo Html::script(Module::asset('workdiaryblog:js').'/highlight.pack.js', ['type' => 'text/javascript']);
		echo Html::script(Module::asset('workdiaryblog:js').'/jquery.slicknav.min.js', ['type' => 'text/javascript']);
		echo Html::script(Module::asset('workdiaryblog:js').'/owl.carousel.min.js', ['type' => 'text/javascript']);
		echo Html::script(Module::asset('workdiaryblog:js').'/main.js', ['type' => 'text/javascript']);
	}

	public function Wbd_not_found_page_func(){
		echo View('workdiaryblog::404');
	}
}