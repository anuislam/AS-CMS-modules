<?php

namespace Modules\Eccommerce\Entities;
use Module;
use Html;
use Breadcrumbs;
use App\UserPermission;

class hooks {

    public function __construct() {
    	$this->register_admin_menu();
    	$this->register_user_role();
    	add_action('load_breadcrumbs', [$this, 'load_breadcrumbs_func']);
    	add_action('admin_header', [$this, 'admin_style_func']);
    }

	public function admin_style_func(){
		echo Html::style(Module::asset('eccommerce:css').'/admin.css');
	}

    public function load_breadcrumbs_func(){

		Breadcrumbs::register('product-attr', function ($breadcrumbs) {
		    $breadcrumbs->push('Product', route('all-posts', 'product'));
		    $breadcrumbs->push('Attributes', route('create-tarms', 'product-attr'));
		    $breadcrumbs->push('Items', '');
		});

		Breadcrumbs::register('shipping_zone_create', function ($breadcrumbs) {
		    $breadcrumbs->push('Shipping Zones',  route('admin-page', 'shipping'));
		    $breadcrumbs->push('Create', '');
		});

    }

    public function register_admin_menu(){

		register_menu([
			'menu-title' 	 	=> 'Product',
			'id' 	 		 	=> 'product',
			'menu-icon' 	 	=> 'fa-shopping-cart', 
			'capability' 	 	=> 'add_product', 
			'menu_position' 	=> 220, 
		]);

		register_dropdown_menu('product', [
			'menu-title' 	 	=> 'All products',
			'id' 	 		 	=> 'all-product', //uniq
			'url' 	 		 	=> ['all-posts', 'product'], //route
			'capability' 	 	=> 'add_product', //uniq
		]);

		register_dropdown_menu('product', [
			'menu-title' 	 	=> 'Add New product',
			'id' 	 		 	=> 'add-new-product', //uniq
			'url' 	 		 	=> ['create_post_type', 'product'], //route
			'capability' 	 	=> 'add_product', //uniq
		]);

		register_dropdown_menu('product', [
			'menu-title' 	 	=> 'Category',
			'id' 	 		 	=> 'product-category', //uniq
			'url' 	 		 	=> ['create-tarms', 'product-cat'], //route
			'capability' 	 	=> 'add_product', //uniq
		]);

		register_dropdown_menu('product', [
			'menu-title' 	 	=> 'Tags',
			'id' 	 		 	=> 'product-tag', //uniq
			'url' 	 		 	=> ['create-tarms', 'product-tag'], //route
			'capability' 	 	=> 'add_product', //uniq
		]);

		register_dropdown_menu('product', [
			'menu-title' 	 	=> 'Attributes',
			'id' 	 		 	=> 'product-attr', //uniq
			'url' 	 		 	=> ['create-tarms', 'product-attr'], //route
			'capability' 	 	=> 'add_product', //uniq
		]);



//************************************************
//Shipping mathod
//************************************************

		register_menu([
			'menu-title' 	 	=> 'Shipping',
			'id' 	 		 	=> 'shipping',
			'menu-icon' 	 	=> 'fa-car', 
			'capability' 	 	=> 'manage_product', 
			'menu_position' 	=> 221, 
			'url' 	 		 	=>  ['admin-page', 'shipping'],
		]);


//************************************************
//register product type
//************************************************

		register_post_type([
			'id' 	 		 	=> 'product', //uniq
			'class' 	 	 	=> 'Modules\Eccommerce\Entities\product_type', //opject name
		]);

//************************************************
//Register tarm
//************************************************

		register_tarm([
			'id' 	 		 	=> 'product-cat', //uniq
			'class' 	 	 	=> 'Modules\Eccommerce\Entities\product_category',
		]);

		register_tarm([
			'id' 	 		 	=> 'product-tag', //uniq
			'class' 	 	 	=> 'Modules\Eccommerce\Entities\product_tag',
		]);

		register_tarm([
			'id' 	 		 	=> 'product-attr', //uniq
			'class' 	 	 	=> 'Modules\Eccommerce\Entities\product_attr',
		]);

//************************************************
//Reginser page
//************************************************


add_admin_page([
	'id' 	 		 	=> 'shipping', //uniq
	'class' 	 	 	=> 'Modules\Eccommerce\Entities\shipping_zone',
]);

add_admin_page([
	'id' 	 		 	=> 'add-shipping', //uniq
	'class' 	 	 	=> 'Modules\Eccommerce\Entities\add_shipping_zone',
]);

add_admin_page([
	'id' 	 		 	=> 'shipping-method', //uniq
	'class' 	 	 	=> 'Modules\Eccommerce\Entities\add_shipping_method',
]);

add_admin_page([
	'id' 	 		 	=> 'shipping-class', //uniq
	'class' 	 	 	=> 'Modules\Eccommerce\Entities\add_shipping_class',
]);

    }

    public function register_user_role(){
		if (Module::has('Permission')) {
			$module = Module::find('Permission');
			$module = $module->json('module.json');
			if ((int)$module->active === 1) {
				$user_role = new UserPermission();
				$user_role->cap('administrator', [
				            'add_product'   => true,
				            'manage_product'   => true,
				            'edith_product'   => true,
				            'delete_product'   => true,
				        ]);
    		}
    	}
    }


}
