<?php 
// =============================================================================
// WOOCOMMERCE CODE SNIPPETS
// =============================================================================

// creating function that verifies if customer bought the item
// you can call this function anywhere :
// if (has_bought_items($id)) {}
// pass the product id into the function
function has_bought_items($id) {
    $bought = false;

    // Set HERE ine the array your specific target product IDs
    
    $prod_arr = array( $id );

    // Get all customer orders
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => 'shop_order', // WC orders post type
        'post_status' => 'wc-completed' // Only orders with status "completed"
    ) );

    // loop through the post orders
    foreach ( $customer_orders as $customer_order ) {
        // Updated compatibility with WooCommerce 3+
        $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
        $order = wc_get_order( $customer_order );

        // Iterating through each current customer products bought in the order
        foreach ($order->get_items() as $item) {
            // WC 3+ compatibility
            if ( version_compare( WC_VERSION, '3.0', '<' ) ) 
                $product_id = $item['product_id'];
            else
                $product_id = $item->get_product_id();

            // Your condition related to your 2 specific products Ids
            if ( in_array( $product_id, $prod_arr ) ) 
                $bought = true;
        }
    }
    // return "true" if one the specifics products have been bought before by customer
    return $bought;
}


// registering menu items
// scenario:
// registering product 'brand' attribute into the navigation menu
add_filter('woocommerce_attribute_show_in_nav_menus', 'wc_reg_for_menus', 1, 2);

function wc_reg_for_menus( $register, $name = '' ) {
     if ( $name == 'pa_brands' ) $register = true;
     return $register;
}


// change order number format
add_filter( 'woocommerce_order_number', 'change_woocommerce_order_number', 1, 2);

function change_woocommerce_order_number( $order_id, $order ) {
	
    $prefix = date('Ymd').'-';
    $suffix = '-'.'TOTAL' ;

    // You can use either one of $order->id (or) $order_id
    return $prefix . $order->id . $suffix;
}


// update user billing details
update_user_meta( $uc_id, 'billing_address_1', $address1 );
update_user_meta( $uc_id, 'billing_address_2', $arr_data["gf_brgy"] );
update_user_meta( $uc_id, 'billing_city', $arr_data["gf_city"] );
update_user_meta( $uc_id, 'billing_state', $addr_arr[0] );
update_user_meta( $uc_id, 'billing_country', $arr_data["gf_country"] );


// update user shipping details
update_user_meta( $uc_id, 'shipping_first_name', $arr_data["gf_fname"] );
update_user_meta( $uc_id, 'shipping_last_name', $arr_data["gf_lname"] );
update_user_meta( $uc_id, 'shipping_address_1', $address1_ship );
update_user_meta( $uc_id, 'shipping_address_2', $arr_data["gf_brgy_ship"] );
update_user_meta( $uc_id, 'shipping_city', $arr_data["gf_city_ship"] );
update_user_meta( $uc_id, 'shipping_state', $addr_arr_ship[0] );
update_user_meta( $uc_id, 'shipping_country', $arr_data["gf_country"] );


// outputting user billing/shipping address data
$b_code = get_user_meta( $id, 'billing_state', true);
$s_code = get_user_meta( $id, 'shipping_state', true);
$country_code = $user_meta['shipping_country'][0];
$billing_state = WC()->countries->get_states( $country_code )[$b_code];
$shipping_state = WC()->countries->get_states( $country_code )[$s_code];

echo $billing_state;
echo $shipping_state;

// adding fees on checkout details
// scenario: adding the e-wallet fee
function wc_add_surcharge() { 
    $uid = get_current_user_id();
    $wallet_points = ( get_field( 'field_59ba6772ba4c7','user_'.$uid ) )? get_field( 'field_59ba6772ba4c7','user_'.$uid ) : 0;
    
    if( $wallet_points > 0 ){
        global $woocommerce; 
        $subtotal = $woocommerce->cart->subtotal;
        $discount = 0;

        //if subtotal is lower
        if( $wallet_points > $subtotal ):
            $discount = number_format($subtotal,0);
        //if wallet points is lower
        else:
            $discount = $wallet_points;
        endif;

        if( $discount > 0){
            $discount *= -1;
            $woocommerce->cart->add_fee( 'E-Wallet Points', $discount, true, 'standard' );  
        }
    }
}
add_action( 'woocommerce_cart_calculate_fees','wc_add_surcharge' ); 


// send coupon if customer ordered more than 2000 pesos worth of purchased
/* scenario: when the referred customer purchased item more than 2000 pesos, 
 the referrer will received the coupon */
function is_express_delivery( $order_id ) {
    global $woocommerce;
    $subtotal = $woocommerce->cart->subtotal;
    $uid = get_current_user_id();

    if( $subtotal >= 2000 ){
        $current_user = wp_get_current_user();
        $email = $current_user->user_login;

        // here the post title is the email address of the referral
        $have_post = get_page_by_title( $email ,'OBJECT', 'referrals-list' );

        if( $have_post ){
            $pid = $have_post->ID;
            if( !get_field( 'field_59c0b112bdacf',$pid ) ){
                // get the id of the referrer
                $aid = $have_post->post_author;
                $code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
                $coupon_code = 'RF-'.$code; // Code
                $amount = '50'; // Amount
                $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product
                $desc = 'this is the coupon description';
                                    
                $coupon = array(
                    'post_title' => $coupon_code,
                    'post_content' => '',
                    'post_excerpt'  => $desc,
                    'post_status' => 'publish',
                    'post_author' => $aid,
                    'post_type'     => 'shop_coupon'
                );
                
                // add new coupon 
                $new_coupon_id = wp_insert_post( $coupon );
                                    
                // Add meta
                update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
                update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
                update_post_meta( $new_coupon_id, 'individual_use', 'yes' );
                update_post_meta( $new_coupon_id, 'product_ids', '' );
                update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
                update_post_meta( $new_coupon_id, 'usage_limit', '1' );
                update_post_meta( $new_coupon_id, 'expiry_date', '' );
                update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
                update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
                update_field( 'field_59c0b112bdacf',true,$pid );
                update_field( 'field_5c10bf5c69eaa',$subtotal,$pid );

                //email coupon to user
                $email_to = get_userdata($aid)->user_email;
                $subject = get_field( 'field_59c0a7651ba2f','option' );
                $body = get_field( 'field_59c0a7741ba30','option' ).'</br></br></br>Coupon Code: '.$coupon_code;
                $headers = array('Content-Type: text/html; charset=UTF-8','From: '.get_field( 'field_59c0a7311ba2e','option' ));
                $mail_res = wp_mail( $email_to, $subject, $body, $headers );
            }
        }
    }
}
add_action( 'woocommerce_checkout_order_processed', 'is_express_delivery',  1, 1  );


// woocommerce shorcodes 
// source: https://docs.woocommerce.com/document/woocommerce-shortcodes/
echo do_shortcode('[sale_products per_page="2" columns="1" orderby="date" order="desc"]');
echo do_shortcode('[featured_products per_page="2" columns="1" orderby="date" order="desc"]');


// modifying field in backend order page
// this will trigger once checkout button is clicked
// data will come from the fields in checkout page
/**
 * Save the order meta with field value
 */ 
function my_custom_checkout_field_update_order_meta( $order_id ) {
    $data = array(
        'billing_bday',
        'billing_gender',
        'shipping__postcode',
    );

    foreach ( $data as $value ) {
        if ( ! empty( $_POST[$value] ) ) {
            update_post_meta( $order_id, $value, sanitize_text_field( $_POST[$value] ) );
        }
    }
}
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );
/**
 * Display field value on the order edit page
 */
// this data will show under the billing address
function my_custom_checkout_field_display_admin_order_meta($order) {
    $data = array(
        'billing_bday'                   => '<strong>Birthday</strong>',
        'billing_gender'                 => '<strong>Gender</strong>',
    );
    foreach ($data as $key => $value) {
        echo '<p>'. $value .' : '. get_post_meta( $order->id, $key, true ) . '</p>';
    }
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

// this data will show under the shipping address
function my_custom_checkout_billing_field_admin_order_meta($order) {
    $data = array(
        'shipping__postcode'            => '<strong>Shipping Postcode,Area</strong>',
        'shipping_recipient_name'        => '<strong>Recipient Name</strong>',
    );
    foreach ($data as $key => $value) {
        echo '<p>'. $value .' : '. get_post_meta( $order->id, $key, true ) . '</p>';
    }
}
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_billing_field_admin_order_meta', 10, 1 );


// loop through top sale product
$args = array(
    'post_type' => 'product',
    'meta_key' => 'total_sales',
    'orderby' => 'meta_value_num',
    'posts_per_page' => 1,
    );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post(); 
global $product; 
?>
<div>
    <a href="<?php the_permalink(); ?>" id="id-<?php the_id(); ?>" title="<?php the_title(); ?>">

        <?php if (has_post_thumbnail( $loop->post->ID )) 
        echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); 
        else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="product placeholder Image" width="65px" height="115px" />'; ?>

        <h3><?php the_title(); ?></h3>
        <p><?php echo $product->get_total_sales(); ?></p>
        <p><?php echo $product->get_sale_price(); ?></p>
        <p><?php echo $product->get_regular_price(); ?></p>
        <p><?php echo $product->get_stock_status(); ?></p>
        <p><?php echo $product->get_average_rating(); ?></p>
        <pre>
            <?php var_dump($product); ?>
        </pre>
    </a>
</div>

<?php endwhile; ?>
<?php wp_reset_query(); ?>


<?php 
// get all product categories
$taxonomy     = 'product_cat';
$orderby      = 'name';  
$show_count   = 0;      // 1 for yes, 0 for no
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no  
$title        = '';  
$empty        = 0;

$args = array(
'taxonomy'     => $taxonomy,
'orderby'      => $orderby,
'show_count'   => $show_count,
'pad_counts'   => $pad_counts,
'hierarchical' => $hierarchical,
'title_li'     => $title,
'hide_empty'   => $empty
);

$all_categories = get_categories( $args );

foreach ($all_categories as $cat) {
    if ($cat->category_parent == 0) {

        $category_id = $cat->term_id;     

        echo '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';

        $args2 = array(
            'taxonomy'     => $taxonomy,
            'child_of'     => 0,
            'parent'       => $category_id,
            'orderby'      => $orderby,
            'show_count'   => $show_count,
            'pad_counts'   => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li'     => $title,
            'hide_empty'   => $empty
        );

        $sub_cats = get_categories( $args2 );
        
        if($sub_cats) {
            foreach($sub_cats as $sub_category) {
                echo  $sub_category->name ;
            }   
        }
    }       
}

var_dump($all_categories);


// product category inside while loop
$terms = get_the_terms( get_the_id(), 'product_cat' );
foreach ($terms as $term) {
    $product_cat_id = $term->name;
    break;
}
echo $product_cat_id;


// formatting price 
echo woocommerce_price( $total );


// custom add to cart button
$product = get_product(1894);
echo "<a href='" . $product->add_to_cart_url() ."'>add to cart</a>";

?>

















?>