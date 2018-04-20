<?php 


function eccommerce_get_shipping_menu_view()
{
?>
	<ul class="ecommerce_menu_admin" style="">
		<li><a href="<?php echo route('admin-page', 'add-shipping'); ?>" class="btn bg-purple">Add shipping zones</a></li>
		<li><a href="<?php echo route('admin-page', 'shipping'); ?>" class="btn bg-purple">Shipping zones</a></li>		
		<li><a href="<?php echo route('admin-page', 'shipping-method'); ?>" class="btn bg-purple">Shipping method</a></li>
		<li><a href="<?php echo route('admin-page', 'shipping-class'); ?>" class="btn bg-purple">Shipping class</a></li>
	</ul>
<?php
}

function eccommerce_get_countrie_name($value){
	if (array_key_exists($value, eccommerce_get_countries())) {
		return eccommerce_get_countries()[$value];
	}
	return false;
}

function eccommerce_get_countries(){
	return array(
		'Dhaka' => 'Dhaka',
		'Faridpur' => 'Faridpur',
		'Gazipur' => 'Gazipur',
		'Gopalganj' => 'Gopalganj',
		'Jamalpur' => 'Jamalpur',
		'Kishoreganj' => 'Kishoreganj',
		'Madaripur' => 'Madaripur',
		'Manikganj' => 'Manikganj',
		'Munshiganj' => 'Munshiganj',
		'Mymensingh' => 'Mymensingh',
		'Narayanganj' => 'Narayanganj',
		'Narsingdi' => 'Narsingdi',
		'Netrokona' => 'Netrokona',
		'Rajbari' => 'Rajbari',
		'Shariatpur' => 'Shariatpur',
		'Sherpur' => 'Sherpur',
		'Tangail' => 'Tangail',
		'Bogra' => 'Bogra',
		'Joypurhat' => 'Joypurhat',
		'Naogaon' => 'Naogaon',
		'Natore' => 'Natore',
		'Nawabganj' => 'Nawabganj',
		'Pabna' => 'Pabna',
		'Rajshahi' => 'Rajshahi',
		'Sirajgonj' => 'Sirajgonj',
		'Dinajpur' => 'Dinajpur',
		'Gaibandha' => 'Gaibandha',
		'Kurigram' => 'Kurigram',
		'Lalmonirhat' => 'Lalmonirhat',
		'Nilphamari' => 'Nilphamari',
		'Panchagarh' => 'Panchagarh',
		'Rangpur' => 'Rangpur',
		'Thakurgaon' => 'Thakurgaon',
		'Barguna' => 'Barguna',
		'Barisal' => 'Barisal',
		'Bhola' => 'Bhola',
		'Jhalokati' => 'Jhalokati',
		'Patuakhali' => 'Patuakhali',
		'Pirojpur' => 'Pirojpur',
		'Bandarban' => 'Bandarban',
		'Brahmanbaria' => 'Brahmanbaria',
		'Chandpur' => 'Chandpur',
		'Chittagong' => 'Chittagong',
		'Comilla' => 'Comilla',
		"Cox'sBazar" => "Cox's Bazar",
		'Feni' => 'Feni',
		'Khagrachari' => 'Khagrachari',
		'Lakshmipur' => 'Lakshmipur',
		'Noakhali' => 'Noakhali',
		'Rangamati' => 'Rangamati',
		'Habiganj' => 'Habiganj',
		'Maulvibazar' => 'Maulvibazar',
		'Sunamganj' => 'Sunamganj',
		'Sylhet' => 'Sylhet',
		'Bagerhat' => 'Bagerhat',
		'Chuadanga' => 'Chuadanga',
		'Jessore' => 'Jessore',
		'Jhenaidah' => 'Jhenaidah',
		'Khulna' => 'Khulna',
		'Kushtia' => 'Kushtia',
		'Magura' => 'Magura',
		'Meherpur' => 'Meherpur',
		'Narail' => 'Narail',
		'Satkhira' => 'Satkhira'
	);
}


function eccommerce_get_bn_name_countries(){
	return array(
			'Dhaka' => 'ঢাকা',
			'Faridpur' => 'ফরিদপুর',
			'Gazipur' => 'গাজীপুর',
			'Gopalganj' => 'গোপালগঞ্জ',
			'Jamalpur' => 'জামালপুর',
			'Kishoreganj' => 'কিশোরগঞ্জ',
			'Madaripur' => 'মাদারীপুর',
			'Manikganj' => 'মানিকগঞ্জ',
			'Munshiganj' => 'মুন্সিগঞ্জ',
			'Mymensingh' => 'ময়মনসিংহ',
			'Narayanganj' => 'নারায়াণগঞ্জ',
			'Narsingdi' => 'নরসিংদী',
			'Netrokona' => 'নেত্রকোণা',
			'Rajbari' => 'রাজবাড়ি',
			'Shariatpur' => 'শরীয়তপুর',
			'Sherpur' => 'শেরপুর',
			'Tangail' => 'টাঙ্গাইল',
			'Bogra' => 'বগুড়া',
			'Joypurhat' => 'জয়পুরহাট',
			'Naogaon' => 'নওগাঁ',
			'Natore' => 'নাটোর',
			'Nawabganj' => 'নবাবগঞ্জ',
			'Pabna' => 'পাবনা',
			'Rajshahi' => 'রাজশাহী',
			'Sirajgonj' => 'সিরাজগঞ্জ',
			'Dinajpur' => 'দিনাজপুর',
			'Gaibandha' => 'গাইবান্ধা',
			'Kurigram' => 'কুড়িগ্রাম',
			'Lalmonirhat' => 'লালমনিরহাট',
			'Nilphamari' => 'নীলফামারী',
			'Panchagarh' => 'পঞ্চগড়',
			'Rangpur' => 'রংপুর',
			'Thakurgaon' => 'ঠাকুরগাঁও',
			'Barguna' => 'বরগুনা',
			'Barisal' => 'বরিশাল',
			'Bhola' => 'ভোলা',
			'Jhalokati' => 'ঝালকাঠি',
			'Patuakhali' => 'পটুয়াখালী',
			'Pirojpur' => 'পিরোজপুর',
			'Bandarban' => 'বান্দরবান',
			'Brahmanbaria' => 'ব্রাহ্মণবাড়িয়া',
			'Chandpur' => 'চাঁদপুর',
			'Chittagong' => 'চট্টগ্রাম',
			'Comilla' => 'কুমিল্লা',
			"Cox'sBazar" => 'কক্সবাজার',
			'Feni' => 'ফেনী',
			'Khagrachari' => 'খাগড়াছড়ি',
			'Lakshmipur' => 'লক্ষ্মীপুর',
			'Noakhali' => 'নোয়াখালী',
			'Rangamati' => 'রাঙ্গামাটি',
			'Habiganj' => 'হবিগঞ্জ',
			'Maulvibazar' => 'মৌলভীবাজার',
			'Sunamganj' => 'সুনামগঞ্জ',
			'Sylhet' => 'সিলেট',
			'Bagerhat' => 'বাগেরহাট',
			'Chuadanga' => 'চুয়াডাঙ্গা',
			'Jessore' => 'যশোর',
			'Jhenaidah' => 'ঝিনাইদহ',
			'Khulna' => 'খুলনা',
			'Kushtia' => 'কুষ্টিয়া',
			'Magura' => 'মাগুরা',
			'Meherpur' => 'মেহেরপুর',
			'Narail' => 'নড়াইল',
			'Satkhira' => 'সাতক্ষীরা',
		);

}


