<?php 
// using wordpress rest api
// examples:
// get user data using post method
function get_allusers($data){
	$email = $data->get_param('email');
	return $email;
}

/* 
get user data from the post body
raw data from the post body:
{
   "code": 12388,
   "discount_type": "fixed_cart",
   "amount": 50,
   "individual_use": true,
   "usage_limit": 1,
   "description": "from wp api",
   "user_id": 96
}

url route: http://famousbrands-ph.com/wp-json/icg/v2/setcoupon
*/
function set_coupon($data) {
    $code = $data['code'];
    return $code;
}

function masurian_api($data) {
	if ( get_field('acffieldname','option') ) {
		return get_field('acffieldname','option'); 
	} else {
		return false;
	}
}

add_action('rest_api_init', function () {

	register_rest_route( 'icg/v2', '/province/municipalities/', array(
		'methods' => 'GET',
		'callback' =>  'masurian_api'
	));

	register_rest_route('icg/v2', '/allusers', array(
		'methods' => 'POST',
		'callback' => 'get_allusers',
		'args' => array(
			'email' => array(
				'required' => true,
				'type' => 'string',
			)
		)
	));

	register_rest_route('icg/v2', 'setcoupon', array(
		'methods' => 'POST',
		'callback' =>  'set_coupon'
	));
	
});

?>