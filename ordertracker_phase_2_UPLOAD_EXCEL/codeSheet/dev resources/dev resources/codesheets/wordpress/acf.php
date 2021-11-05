<?php 

// get field
$post_id = false; // current post
$post_id = 1; // post ID = 1
$post_id = "user_2"; // user ID = 2
$post_id = "category_3"; // category term ID = 3
$post_id = "event_4"; // event (custom taxonomy) term ID = 4
$post_id = "option"; // options page
$post_id = "options"; // same as above

$value = get_field( 'my_field', $post_id );
$value = get_field( 'field_59c0a7651ba2f','option' );
echo $value;


// updating field
update_field($selector, $value, $post_id);
update_field( 'field_5c10c72335945', 'new value', 2 );


// acf repeater field
$field_key = "field_597fd425125fd";
$value = get_field($field_key, $user_id);

// row 1
$value[] = array(
    "field_597fd4e9125fe" => $address1,
    "field_597fd4f4125ff" => $arr_data["gf_brgy"],
    "field_597fd50512600" => $arr_data["gf_city"],
    "field_597fd56412603" => $addr_arr[0],
    "field_59811eacf3802" => $fulladdr,
    "field_59a6484d3f9a7" => true
);

// row 2
$value[] = array(
    "field_597fd4e9125fe" => $address1_ship,
    "field_597fd4f4125ff" => $arr_data["gf_brgy_ship"],
    "field_597fd50512600" => $arr_data["gf_city_ship"],
    "field_597fd56412603" => $addr_arr_ship[0],
    "field_59811eacf3802" => $fulladdr_ship,
    "field_598143def4e37" => true
);

// update the repeater field and insert the value array
update_field( $field_key, $value, $user_id );

 
// loop through a repeater field
if( have_rows('field_597fd425125fd',$uid) ) :
	while( have_rows('field_597fd425125fd',$uid) ) : the_row();

			// get subfields data
			$result['addr1'] = get_sub_field('field_597fd4e9125fe');
			$result['addr2'] = get_sub_field('field_597fd4f4125ff');
			$result['city'] = get_sub_field('field_597fd50512600');
			$result['state'] = get_sub_field('field_597fd56412603');
			
	endwhile;
endif;

// acf options
if ( function_exists('acf_add_options_sub_page') ) {
    /**
     * Theme Settings
     */
    acf_add_options_page ( array(
        'title'         => 'Theme Settings',
        'menu_title'    => 'Theme Settings',
        'capability'    => 'manage_options',
        'redirect'      => false
    ) );

    /**
     * Download Settings
     * adds acf option on the specific post type
     */
    acf_add_options_sub_page( array(
        'page_title'    => 'Download Settings',
        'menu_title'    => 'Download Settings',
        'menu_slug'     => 'download-settings',
        'capability'    => 'manage_options',
        'parent_slug'   => 'edit.php?post_type=download-items',
    ) );
}





















?>