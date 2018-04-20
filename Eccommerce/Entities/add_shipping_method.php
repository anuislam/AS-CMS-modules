<?php 

namespace Modules\Eccommerce\Entities;

use App\admin_page;
use Form;
use Auth;
use Validator;
use DB;
use Purifier;
use Modules\Eccommerce\Entities\Shipping;

/**
* Shiipng All zome
*/
class add_shipping_method extends admin_page
{

	public function page_setting(){
    	return [
    		'page_title' => 'Add shiipng',
    		'page_sub_title' => 'Method',
    		'capability' => 'manage_product',
    	];
    }

    public function page_content_output($error_msg = ''){
        ?>
        <div class="row">
            <div class="col-md-8">
            <?php eccommerce_get_shipping_menu_view(); ?>
            <?php echo Form::open(['url' =>  route('option-update', 'shipping-method'), 'method' => 'PUT']); ?>
                <?php echo heml_card_open('fa fa-list', 'Add shiipng method'); ?>

                <?php echo text_field([
                    'name' => 'method_title',
                    'title' => 'Method title',
                    'value' => old('method_title'),
                    'atts' =>  [
                      'placeholder' => 'Method title',
                      'class' => 'form-control',
                    ]
                    ], $error_msg); ?>

                <?php echo  select_field([
                    'name' => 'tax_status',
                    'title' => 'Tax status',
                    'value' => old('tax_status'),
                    'atts' =>  [ 
                        'class' => 'form-control select2', 
                        'style' => 'width: 100%;',
                      ],
                    'items' =>  [
                        'taxable' => 'Taxable',
                        'none' => 'None',
                    ],
                  ], $error_msg); ?>

                <?php echo text_field([
                    'name' => 'cost',
                    'title' => 'Cost',
                    'value' => old('cost'),
                    'atts' =>  [
                      'placeholder' => 'cost',
                      'class' => 'form-control',
                    ]
                    ], $error_msg); ?>

                <?php echo heml_card_close(); ?>
            <?php echo Form::close(); ?>
            </div>
        </div>
        <?php
    }
	public function option_validation($data){
		return Validator::make($data, []);
	}
    public function option_update($data){
    	return false;
    }

}