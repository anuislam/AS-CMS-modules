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
class add_shipping_zone extends admin_page
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

                <?php echo  select_field([
                    'name' => 'zone_regions[]',
                    'title' => 'Zone regions',
                    'value' => old('zone_regions'),
                    'atts' =>  [ 
                        'class' => 'form-control select2', 
                        'style' => 'width: 100%;',
                        'multiple' => 'multiple',
                      ],
                    'items' =>  eccommerce_get_countries(),
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
    	return Validator::make($data, [
                'zone_name'        => 'required|string|max:255',
                'zone_regions'     => 'required|array',
            ]
        );
    }
    public function option_update($data){
    	$zone_regions = [];
    	if (is_array($data['zone_regions'])) {
    		foreach ($data['zone_regions'] as $zonekey => $zonevalue) {
    			$zone_regions[] = sanitize_text($zonevalue);
    		}
    	}
    	Shipping::zone()->insert([
    		'zone_name' => sanitize_text($data['zone_name']),
    		'zone_regions' => serialize($zone_regions),
    	]);
    	return redirect()->route('admin-page', 'shipping')->with('success_msg', 'Shipping Create Successful.');
    }
}