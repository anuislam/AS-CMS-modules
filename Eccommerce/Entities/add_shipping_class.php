<?php 
namespace Modules\Eccommerce\Entities;

use App\TarmModel;
use App\mediaModel;
use App\admin_page;
use App\post;
use Form;
use Auth;
use Validator;
use DB;
use Purifier;
use Modules\Eccommerce\Entities\Shipping;

/**
* Add Shipping zone
*/
class add_shipping_class extends admin_page
{
	
	public function page_setting(){
    	return [
    		'page_title' => 'Add shiipng',
    		'page_sub_title' => 'Zone',
    		'capability' => 'manage_product',
    	];
    }

    public function page_content_output($error_msg = ''){

    	?>
    	<div class="row">
      		<div class="col-md-8">
	      	<?php eccommerce_get_shipping_menu_view(); ?>
	    	<?php echo Form::open(['url' =>  route('option-update', 'add-shipping'), 'method' => 'PUT']); ?>
		    	<?php echo heml_card_open('fa fa-list', 'Add Shipping zone'); ?>

                <?php echo text_field([
                    'name' => 'zone_name',
                    'title' => 'Zone name',
                    'value' => old('zone_name'),
                    'atts' =>  [
                      'placeholder' => 'Zone name',
                      'class' => 'form-control',
                    ]
                    ], $error_msg); ?>

                <?php echo text_field([
                    'name' => 'slug_name',
                    'title' => 'Slug name',
                    'value' => old('slug_name'),
                    'atts' =>  [
                      'placeholder' => 'Slug name',
                      'class' => 'form-control',
                    ]
                    ], $error_msg); ?>

				<?php echo textarea_field([
					'name' => 'description',
					'title' => 'Description',
					'value' => old('description'),
					'atts' =>  [
					  'placeholder' => 'Description',
                      'class' => 'form-control',
					]
					], $error_msg); ?>

				<?php echo Form::submit('Save', ['class' => 'btn bg-olive btn-flat pull-left']); ?>
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