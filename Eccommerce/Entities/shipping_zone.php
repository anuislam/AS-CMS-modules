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
* Shiipng All zome
*/
class shipping_zone extends admin_page
{

	public function page_setting(){
    	return [
    		'page_title' => 'Shiipng',
    		'page_sub_title' => 'Zones',
    		'capability' => 'manage_product',
    	];
    }

    public function page_content_output($error_msg = ''){
        ?>
        <div class="row">
            <div class="col-md-12">
            <?php eccommerce_get_shipping_menu_view(); ?>
                <?php echo heml_card_open('fa fa-list', 'Shipping zones'); ?>
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">       
                        <thead>
                          <tr>
                            <th>Shipping method title</th>
                            <th>Zone regions</th>
                            <th>Description</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>                            
                            <?php $shipping_zones = Shipping::zone()->orderby('id', 'DESC')->get(); ?>
                            <?php if (count($shipping_zones) > 0): ?>
                                <?php foreach ($shipping_zones as $shippingkey => $shippingvalue) : ?>
                                    <tr>
                                        <td><?php echo $shippingvalue->zone_name; ?></td>
                                        <td><?php 
                                        $shippingvalue->zone_regions = unserialize($shippingvalue->zone_regions);
                                        if (is_array($shippingvalue->zone_regions)) {                                            
                                            foreach ($shippingvalue->zone_regions as $regionkey => $regionvalue) {
                                                echo '<span class="label label-success" style="margin:0 5px;">';
                                                echo eccommerce_get_countrie_name($regionvalue);
                                                echo '</span>';
                                            }

                                        }
                                         ?></td>
                                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td> 
                                        <td>
                                            <a href="" class="btn btn-default">Add shipping method</a>
                                            <a href="http://laravel/admin-panel/media/1/edit" class="btn bg-purple btn-flat margin">Edith</a><a 
                                            onclick="data_modal(this)" 
                                            data-title="Ready to Delete?" 
                                            data-message="Are you sure you want to delete this media?" 
                                            cancel_text="Cancel" 
                                            submit_text="Delete" 
                                            data-type="post" 
                                            data-parameters="{'_token':'azk9k3T44TajDShBzCaXBEgB0furkpHAXtA6Uzri', '_method': 'DELETE'}" 
                                            href="http://laravel/admin-panel/media/1" 
                                            class="btn bg-maroon btn-flat">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif ?>                            

                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Shipping method title</th>
                            <th>Zone regions</th>
                            <th>Description</th>
                            <th>Action</th>                           
                          </tr>
                        </tfoot>
                    </table>
                <?php echo heml_card_close(); ?>
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