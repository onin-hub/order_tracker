<?php 

// =============================================================================
// WORDPRESS FUNCTIONS
// =============================================================================

// signature
/* >>>>> dev_pco */

// code here..

/* <<<<< dev_pco */


// load header, footer, sidebar template
get_header( string $name = null );
get_header();
get_footer();
get_sidebar();

// for file named 'header-home.php'
get_header('home');

// iterate the post index in the loop.
the_post(); 

// show site details
bloginfo( string $show = '' );
bloginfo();

// with prefix get_ will not print the returned value but can be saved for used in variables
get_bloginfo();

// display the post content.
the_content();

// loads template part into a template
get_template_part( string $slug, string $name = null );

// file named: content-page.php inside subfolder named: template-parts
get_template_part('template-parts/content', 'page');

// retrieves the URL for the current site where the front end is accessible.
home_url( string $path = '', string|null $scheme = null );

// displays the contents of the search query variable.
the_search_query();

// retrieves the contents of the search WordPress query variable.
get_search_query( bool $escaped = true );

// retrieve paginated link for archive post pages.
paginate_links( string|array $args = '' );

// used this inside loop of archived posts to display pagination links
paginate_links( [] );

// displays the navigation to next/previous set of posts, when applicable
the_posts_navigation( array $args = array() );

// returns the ‘site_url’ option with the appropriate protocol, ‘https’ if is_ssl() and ‘http’ otherwise. If $scheme is ‘http’ or ‘https’, is_ssl() is overridden.
get_site_url( int $blog_id = null, string $path = '', string $scheme = null );
get_site_url();

// redirect to another page
wp_redirect( string $location, int $status = 302 );

// note: wp_redirect() does not exit automatically, and should almost always be followed by a call to exit;
wp_redirect( $url );
exit;

// sample redirect path
echo get_the_permalink().'?id='.$uid;


// adds a hook for a shortcode tag.
add_shortcode( $tag , $func );

// search content for shortcodes and filter shortcodes through their hooks.
do_shortcode( string $content, bool $ignore_html = false );
do_shortcode('[shortcode]');

// retrieve post meta field for a post.
// will be an array if $single is false. Will be value of meta data field if $single is true.
get_post_meta( int $post_id, string $key = '', bool $single = false );

// retrieve list of latest posts or posts matching criteria.
// $args (array) (Optional) arguments to retrieve posts. See WP_Query::parse_query() for all available arguments.
get_posts( array $args = null );

// retrieves an object which describes any registered post type (i.e. built-in types like 'post' and 'page', or any user-created custom post type).
get_post_type_object( $post_type );

// retrieves the post type of the current post or of a given post.
// $post (int|WP_Post|null) (Optional) Post ID or post object. Default is global $post.
get_post_type( int|WP_Post|null $post = null );
// get the post type of a post by id
get_post_type($post_id);

// create an action, where all custom user defined function hooked/attached in this action will be executed
// place this function where you want a function to be executed in a certain point
do_action( $tag, $arg = '' );

// hook a custom user defined function to a pre defined wordpress action
// hooks a custom function on to a specific action.
add_action( string $tag, callable $function_to_add, int $priority = 10, int $accepted_args = 1 );

// create a filter, where all custom user defined function hooked/attached in this action will be executed
// execute a custom hooked function
apply_filters( $tag, $value );

// hook a custom function to a filter created using apply_filter();
add_filter( $tag, $function_to_add, 10, 1 );

// fire the wp_head action, put this before the </head> tag
wp_head();

// fire the wp_footer action, put this before the </body> tag
wp_footer();

// enqueue a CSS stylesheet
wp_enqueue_style( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, string $media = 'all' );

// enqueue a script
wp_enqueue_script( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, bool $in_footer = false );

// enqueuing cdn source css / js sample
wp_enqueue_style( 'aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css','',null );
wp_enqueue_script( 'aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', null, true );

// enqueuing file source css / js sample
wp_enqueue_style( 'mm-css', get_template_directory_uri() .'/vendors/mmenu/dist/jquery.mmenu.all.css','',null );
wp_enqueue_script( 'mm-js', get_template_directory_uri() .'/vendors/mmenu/dist/jquery.mmenu.all.js', array( 'jquery' ), '', true );

// invoking navigation menu
wp_nav_menu($args);

// registering the menu location
register_nav_menu( $location, $description );
register_nav_menus($args);

// invoking dynamic sidebar
dynamic_sidebar();

// registering the dynamic sidebar
register_sidebar($args);

// list all pages
wp_list_pages($args);

// retrieve the currently-queried object
// get data of the current object/post/page
get_queried_object()

// get post link
get_the_permalink( $post, false );

// get term link
get_term_link( $term->name, $taxonomy_name );

// metadata
// get all metadata of a specific object (user, post, etc.)
get_metadata( string $meta_type, int $object_id, string $meta_key = '', bool $single = false );

// get meta data by user id
// value folse to return an array of data, change value to true to return only the value
get_user_meta( $user_id, 'metakey', false );

// update meta value
update_user_meta( $id, 'metakey', $value );

// get post meta field
$post_meta = get_post_meta( $post_id );

// trim string by words
// wp_trim_words( $content, 55, '...' )
wp_trim_words( string $text, int $num_words = 55, string $more = null )

// delete post
wp_delete_post( $post_id );

// get post content
get_post_field('post_content', $post->ID);


// =============================================================================
// WORDPRESS CODE SNIPPETS
// =============================================================================

// *****************************
// LOOPS
// *****************************

// the famous wordpress loop
// looped the post content
// loop through the posts based on the current page post type
// put this lines of code at post archive
if(have_posts()):
    while(have_posts()): the_post();

       	the_content();

    endwhile;
endif;


// loop through a specific post type
$args = array(
	'post_type' => 'post',
	'posts_per_page' => 3, // put -1 to get all posts
	'orderby' => 'date',
    'order'   => 'DESC',
);

$post_query = new WP_Query($args);

if($post_query->have_posts() ) :

	while($post_query->have_posts() ) : $post_query->the_post();
		?>
			<h2><?php the_title(); ?></h2>
			<p><?php the_content(); ?></p>
		<?php
	endwhile;

endif;


// loop through a post by id
$args = array(
	'post_type' => 'program',
	'post__in' => array($id)
	);

$posts = get_posts($args);

echo $posts[0]->post_title;


// list child page of current post
$args = array(
	'child_of' => $post->ID,
	'title_li' => ''
);
wp_list_pages($args);


// getting recent post data
$args = array(
	'numberposts' => 5,
	'offset' => 0,
	'category' => 0,
	'orderby' => 'post_date',
	'order' => 'DESC',
	'include' => '',
	'exclude' => '',
	'meta_key' => '',
	'meta_value' =>'',
	'post_type' => 'news-list',
	'post_status' => 'draft, publish, future, pending, private',
	'suppress_filters' => true
);

$posts = wp_get_recent_posts( $args, OBJECT );


// *****************************
// POSTS/POST TYPES
// *****************************

// custom post type
// Register Post Type
function webt_post_type()
{
    $labels = array(
		'name'               => __( 'Plural Name', 'webt' ),
		'singular_name'      => __( 'Singular Name', 'webt' ),
		'add_new'            => _x( 'Add New Singular Name', 'webt', 'webt' ),
		'add_new_item'       => __( 'Add New Singular Name', 'webt' ),
		'edit_item'          => __( 'Edit Singular Name', 'webt' ),
		'new_item'           => __( 'New Singular Name', 'webt' ),
		'view_item'          => __( 'View Singular Name', 'webt' ),
		'search_items'       => __( 'Search Plural Name', 'webt' ),
		'not_found'          => __( 'No Plural Name found', 'webt' ),
		'not_found_in_trash' => __( 'No Plural Name found in Trash', 'webt' ),
		'parent_item_colon'  => __( 'Parent Singular Name:', 'webt' ),
		'menu_name'          => __( 'Plural Name', 'webt' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => null,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'custom-fields',
			'trackbacks',
			'comments',
			'revisions',
			'page-attributes',
			'post-formats',
		),
	);
	register_post_type( 'slug', $args );

}
add_action( 'init', 'webt_post_type' );


// post type under another custom post type
// scenario: custom post type notification will show under custom post type projects
function dst_register_post_types() {
	$labels = array(
		'name' 					=> 'Notifications',
		'singular_name'			=> 'Notifications',
		'add_new' 				=> 'Add New',
		'add_new_item' 			=> 'Add New Item',
		'edit_item' 			=> 'Edit Notifications',
		'new_item' 				=> 'New Item',
		'all_items' 			=> 'Notifications',
		'view_item' 			=> 'View Metrodental Notifications',
		'search_items' 			=> 'Search Metrodental Notifications',
		'not_found' 			=> 'Nothing found.',
		'not_found_in_trash'	=> 'Nothing found in Trash.',
		'parent_item_colon' 	=> '',
		'menu_name' 			=> 'Notifications'	
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> false,
		'publicly_queryable' 	=> false,
		'show_ui' 				=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'has_archive' 			=> false,
		'hierarchical'			=> false,
		'show_in_menu'			=> 'edit.php?post_type=projects',
		'menu_position' 		=> '',
		'supports' 				=> array('title','author'),
	);
	
	register_post_type( 'notifications', $args );
}
add_action( 'init', 'dst_register_post_types' );


// custom post type field placeholder
function wpb_change_title_text( $title ){
     $screen = get_current_screen();
  
     if  ( 'directory' == $screen->post_type ) {
          $title = 'Enter Fullname here..';
     }
  
     return $title;
}
add_filter( 'enter_title_here', 'wpb_change_title_text' );


// get custom query
// modifiying archive list
// display archive list based on the value of $_GET method
function hwl_home_pagesize( $query ) {
     if ( ! is_admin() && $query->is_main_query() ) {

	    if ( is_post_type_archive( 'directory' ) ) {
	        // Display 15 posts for a custom post type called 'directory'
	        $query->set( 'posts_per_page', 15 );

	        if (isset($_GET['location'])) {
				$location = $_GET['location'];

				$query->set( 'meta_query', array(
					array(
						'key' => 'provincecity', // acf field name
						'value' => $location,
						'compare' => 'LIKE',
					)
	          	));
	        }

	        return $query;
	    }
	}
}
add_action( 'pre_get_posts', 'hwl_home_pagesize', 1 );


// The Code below will modify the main WordPress loop, before the queries fired,
// to only show posts in the halloween category on the home page.
function sbt_exclude_category($query){
    if ( $query->is_home() && $query->is_main_query() && ! is_admin() ) {
         
        $query->set( 'category_name', 'halloween' );

    }
}
add_action('pre_get_posts','sbt_exclude_category');


// Example for how to universally adjust queries for an ‘event’ post type:
function universally_adjust_queries($query){
   if ( ! is_admin() && is_post_type_archive( 'event' ) && $query->is_main_query() ) {

        $query->set( 'meta_key', 'event_date' );
        $query->set( 'orderby', 'meta_value_num' );
        $query->set( 'order', 'ASC');

        $query->set( 'meta_query', array(
            array(
                'key'     => 'event_date',
                'compare' => '>=',
                'value'   => date('Ymd'),
                'type'    => 'numeric',
            )
        ) );
   }
}
add_action( 'pre_get_posts', 'universally_adjust_queries' );


// creating pagination on archive page using pre_get_posts
// customize post number per page
function segment_pagesize( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {

        if ( is_post_type_archive( 'segment' ) ) {

            $query->set( 'posts_per_page', 5 );

            return $query;
        }

    }
}
add_action( 'pre_get_posts', 'segment_pagesize', 1 );

// put this line of code in archive page
// customize your pagination by passing arguments
?>
<!-- css -->
<style type="text/css">
	div#custom-pagination .page-numbers {
		background-color: #f4f4f4;
		color: #005da4;
		padding: 13px 20px;
		font-weight: 700;
		cursor: pointer;
		text-decoration: none;
		transition: all 0.2s ease-out .1s;

		&:hover {
			background-color: #005da4;
			color: #f4f4f4;
		}
	}

	div#custom-pagination {
		margin: 5% auto;
	}

	div#custom-pagination .page-numbers.current {
		background-color: #005da4;
		color: #f4f4f4;
	}
</style>

<div class="row text-center">
	<?php 
	$args = array(
		'prev_next'          => true,
		'prev_text'          => __('Prev'),
		'next_text'          => __('Next'),
		'type'               => 'plain',
	);
	?>
	<div id="custom-pagination" class="col-lg-12"><?php echo paginate_links( $args ); ?></div>
</div>
<?php


// another way of paginating posts for non-archive page
// paginating taxonomy terms
// put this line of code under terms loop (taxonomy-{tax-slug}.php file)
?>
<div class="row text-center">
	<?php 
	$args = array(
		'prev_next'          => true,
		'prev_text'          => __('Prev'),
		'next_text'          => __('Next'),
		'type'               => 'plain',
	);
	?>
	<div id="custom-pagination" class="col-lg-12"><?php echo paginate_links( $args ); ?></div>
</div>
<?php

// then put this on your function.php file
function wpsites_query( $query ) {
if ( $query->is_archive() && $query->is_main_query() && !is_admin() ) {
        $query->set( 'posts_per_page', 9 );
    }
}
add_action( 'pre_get_posts', 'wpsites_query' );


// insert a post in a post type from another post type
/* 
	scenario:
	when a post (status: draft) is published, a post will insert to another post type
*/

// filter post data when updated
function filter_handler( $data , $postarr ) {
	
	// get the published post data 
	$post_id = $postarr['post_ID'];
	$post_type = get_post_type($post_id);
	$status = $postarr['original_post_status'];
	$pid = $postarr['acf']['field_59b73d9a4a3dc'];
	$oid = $data['post_title'];

	// customer id who created the post
	$cust_id = $postarr['author'];

	// id of the administrator
	$uid = $postarr['user_ID'];
	

	if( $post_type == 'returns-list' ){ //if post type is returns list

		if(strtolower($status) == 'draft'){

			if( have_rows('field_59b8c8d7f85cd',$oid) ){
				while( have_rows('field_59b8c8d7f85cd',$oid) ){ the_row();
					if( get_sub_field( 'field_59b8c88168608' ) == $pid ){

						//enable return button
						$count = get_sub_field( 'field_59b8c89368609' );
						if( $count > 0) $count -= 1;
						update_sub_field( 'field_59b8c89368609',$count );
						
						//add ewallet points
						$points = intval(get_field('field_59b7379fa2598'));
						// $valid_date = date('m/d/Y',strtotime('+1 year',time('today')));
						$descr = "Returned ".get_field( 'field_59b735b6a2594' )." using E-Wallet points";
						
						$code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));//generate code
						
				   		while( true ){
				   			if(post_exists( $code )){
				   				$code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));//generate code
				   			} else {
				   				break;
				   			}
				   		}

						$postarr = array(
							'post_author' => $uid,
							'post_title'  => $code ,
							'post_type'   => 'e-wallet',
							'post_status' => 'publish'
						);

						// insert a post into another post type
						$npid = wp_insert_post( $postarr  );

						update_field( 'field_59ba42ef94643',$points,$npid );
						// update_field( 'field_59ba432494644',$valid_date,$npid );
						update_field( 'field_59ba42e294642',$descr,$npid );

						$npoints = get_field( 'field_59ba6772ba4c7','user_'.$uid );
						$npoints = ($npoints)? $npoints+$points : $points;
						update_field( 'field_59ba6772ba4c7',$npoints,'user_'.$uid );
						update_field( 'field_59bb5eae1c046',$valid_date,'user_'.$uid );
						
						break;
					}
				}
			}
		}
	}

    return $data;
}

add_filter( 'wp_insert_post_data', 'filter_handler', '99', 2 );


// alternative to wp_insert_post_data
// trigger when post was saved
add_action( 'save_post', 'set_post_default_category', 10,3 );
 
function set_post_default_category( $post_id, $post, $update ) {
	// do code here
}


// *****************************
// TAXONOMY/TERMS
// *****************************

// creating taxonomy
function webt_taxonomy() {
	// Taxonomy
	$labels = array(
		'name'              => _x( 'Plural Name', 'taxonomy general name', 'webt' ),
		'singular_name'     => _x( 'Singular Name', 'taxonomy singular name', 'webt' ),
		'search_items'      => __( 'Search Plural Name', 'webt' ),
		'all_items'         => __( 'All Plural Name', 'webt' ),
		'parent_item'       => __( 'Parent Singular Name', 'webt' ),
		'parent_item_colon' => __( 'Parent Singular Name:', 'webt' ),
		'edit_item'         => __( 'Edit Singular Name', 'webt' ),
		'update_item'       => __( 'Update Singular Name', 'webt' ),
		'add_new_item'      => __( 'Add New Singular Name', 'webt' ),
		'new_item_name'     => __( 'New Singular Name Name', 'webt' ),
		'menu_name'         => __( 'Singular Name', 'webt' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'cat-slug' ),
	);

	register_taxonomy( 'cat-slug', array( 'post_type-slug' ), $args );

}
add_action( 'init', 'webt_taxonomy');

// get taxonomy name of current post
// taxonomy is the group name itself (e.g. brands)
$taxonomy_name = get_queried_object()->taxonomy;

// term is the name of the item in the group (e.g. nike)
// get the term id of current post
$term_id = get_queried_object()->term_id;

// get children of the current term parent
$termchildren = get_term_children( $term_id, $taxonomy_name );

// loop through each term children
foreach ($termchildren as $child) {
	// get the term object
	$term = get_term_by( 'id', $child, $taxonomy_name );
}


// write this line of code in a template-page
// then create taxonomy-{tax-slug}.php, this will serve as the single page for each term
$taxonomy_name = 'pillars';

$terms = get_terms(array(
	'taxonomy' => $taxonomy_name,
	'hide_empty' => false,
));

foreach ($terms as $term) {
	?>
		<a href="<?php echo get_term_link( $term->name, $taxonomy_name ); ?>"><?php echo $term->name; ?></a>
	<?php
}


// loop through post based on terms of taxonomy
?>
<div class="__trending_stories_container">
	<p>Trending News</p>
	<?php 
	$args = array(
		'post_type' => 'news',
		'posts_per_page' => 3,
		'tax_query' => array(
			array(
				'taxonomy' => 'news-category',
				'field'    => 'slug',
				'terms'    => array('trending'),
			),
		),
	);

	$news = new WP_Query( $args );

	if ( $news->have_posts() ):
		while( $news->have_posts() ): $news->the_post(); ?>
			<a class="__trending_news" href="<?php echo get_permalink(); ?>">                 
				<div>
					<p class="__trending_news_title"><?php echo get_the_title(); ?></p>
					<p><?php echo get_the_date('F j, Y') ?></p>
				</div>
			</a>
		<?php endwhile; ?>
	<?php else: ?>
		<div>
			<p class="__trending_news_title">NO TRENDING NEWS AVAILABLE.</p>
		</div>
	<?php endif; ?>
</div>
<?php
			

// *****************************
// MENU/SIDEBARS/WIDGETS
// *****************************

// navigation menu
$menu_args = array(
	'theme_location' => 'top'
);

wp_nav_menu( $menu_args );


// registering the menu
function webt_theme_setup() {
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'webt' )
	) );
}
add_action( 'after_setup_theme', 'webt_theme_setup' );


// registering a sidebar
// access the sidebar at wp-admin backend/appearance/widget
function wpdocs_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar', 'textdomain' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'textdomain' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );


// invoking the sidebar
if ( is_active_sidebar( 'sidebar-1' ) ) :
	dynamic_sidebar( 'sidebar-1' );
endif;


// invoking the list of sidebar
function get_my_widgets() {
	foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
		$sidebar_options[$sidebar['id']] = $sidebar['name'];
	}
}
add_action('init','get_my_widgets');


// custom active class navigation menu
function add_current_nav_class($classes, $item) {

	// Getting the current post details
	global $post;

	// Getting the post type of the current post
	$current_post_type = get_post_type_object(get_post_type($post->ID));
	$current_post_type_slug = $current_post_type->rewrite[slug];

	// Getting the URL of the menu item
	$menu_slug = strtolower(trim($item->url));

	// If the menu item URL contains the current post types slug add the current-menu-item class
	if (strpos($menu_slug,$current_post_type_slug) !== false) {

		$classes[] = 'current-menu-item';

	}

	// Return the corrected set of classes to be added to the menu item
	return $classes;
}
add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2 );


// *****************************
// OTHER FUNCTIONS
// *****************************

// adding custom shortcode
// creating shorcode [facebook_feeds]
function facebook_feeds_shortcode() {
    ob_start();

	    ?>
			<iframe 
				id="fb-page" 
				src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FYANAphilippines%2F&width=300&height=200&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" 
				width="300" 
				height="200" 
				style="border:none;overflow:hidden" 
				scrolling="no" 
				frameborder="0" 
				allowTransparency="true" 
				allow="encrypted-media">
			</iframe>
	    <?php

   return ob_get_clean();
}
add_shortcode( 'facebook_feeds', 'facebook_feeds_shortcode' );


// redirect after logout
function auto_redirect_after_logout() {
	wp_redirect( home_url() );
	exit();
}
add_action('wp_logout','auto_redirect_after_logout');


// formatting wordpress date and time
$date = $blogs[0]['blogs'] -> post_date;
$date = date('F j, Y', strtotime($date));
echo $date;


// stylesheet browser compatibility
$u_agent = $_SERVER['HTTP_USER_AGENT'];

if( preg_match( '/trident/i', $u_agent ) ) {
	/**
	* Enqueue your style/script only @ IE
	*/
	wp_enqueue_style('ie', THEME_URL .'/assets/style/css/ie.css');
} 
elseif( preg_match( '/firefox/i', $u_agent ) ) {
	/**
	* Enqueue your style/script only @ Mozilla Firefox
	*/
	wp_enqueue_style('firefox', THEME_URL .'/assets/style/css/firefox.css');
} 
elseif( preg_match( '/mac/i', $u_agent ) ) {
	/**
	* Enqueue your style/script only @ Safari
	*/
	wp_enqueue_style('safari', THEME_URL .'/assets/style/css/safari.css');
} 
elseif( preg_match( '/chrome/i', $u_agent ) ) {
	/**
	* Enqueue your style/script only @ Google Chrome
	*/
	wp_enqueue_style('chrome', THEME_URL .'/assets/style/css/chrome.css');
} 
elseif( preg_match( '/Opera/i',$u_agent ) || preg_match( '/OPR/i',$u_agent ) ) {
	/**
	* Enqueue your style/script only @ Opera
	*/
	wp_enqueue_style('opera', THEME_URL .'/assets/style/css/opera.css');
}


// including a file 
/* 
	scenario:
	- file name: initiliazation.php
	- file path: themes/themename/inc/initiliazation.php
	- file to be included @: functions.php
*/

// code @: functions.php
include_once( 'inc/initialization.php' );


// kill script if file was access directly
// put this line function at the top of every file
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


// appending a script in wp_footer
function signup_success() {
    if(isset($_GET['signup_success']) && $_GET['signup_success'] == 1){

        echo "<script>";
            echo "jQuery('#p-success-box').show();";
        echo "</script>";

    }
}
add_action('wp_footer', 'signup_success');


// calling script with condition
if ( $post_score <= 5 ) {
	echo '<script type="text/javascript">

		(function($){

			"use strict";

			swal({
			  title: "Good job!",
			  text: "You clicked the button!",
			  icon: "success",
			  button: "Aww yiss!",
			});

		})(jQuery);

		</script>';
}


// get user data using WP_User_Query
// get user data based on string inputted by user
// references:
// https://rudrastyh.com/wordpress/get-user-id.html
// https://wordpress.stackexchange.com/questions/105168/how-can-i-search-for-a-worpress-user-by-display-name-or-a-part-of-it
$input_string = '54421';

$users = new WP_User_Query( array(
    'search'         => '*'.esc_attr( $input_string ).'*',
    'search_columns' => array(
        'user_login',
        'user_nicename',
        'user_email',
        'user_url',
    ),
) );

$users_found = $users->get_results();

foreach ($users_found as $user) {
	var_dump($user);
	var_dump($user->ID);
	var_dump($user->user_login);
}


// displaying content if page is home or frontpage
if ( is_front_page() && is_home() ) {
	// Default homepage
} elseif ( is_front_page()){
	//Static homepage
} elseif ( is_home()){
	//Blog page
} else {
	//everything else
}


// tiny mce custom functions
function mce_custom_fonts( $init ) {
    $theme_advanced_fonts = "Andale Mono=andale mono,times;" .
                            "Arial=arial,helvetica,sans-serif;" .
                            "Arial Black=arial black,avant garde;" .
                            "Book Antiqua=book antiqua,palatino;" .
                            "Comic Sans MS=comic sans ms,sans-serif;" .
                            "Courier New=courier new,courier;" .
                            "Georgia=georgia,palatino;" .
                            "Helvetica=helvetica;" .
                            "Impact=impact,chicago;" .
                            "Montserrat=Montserrat;" .                          
                            "Symbol=symbol;" .
                            "Tahoma=tahoma,arial,helvetica,sans-serif;" .
                            "Terminal=terminal,monaco;" .
                            "Times New Roman=times new roman,times;" .
                            "Trebuchet MS=trebuchet ms,geneva;" .
                            "Verdana=verdana,geneva;" .
                            "Webdings=webdings;" .
                            "Wingdings=wingdings,zapf dingbats";
    $init['font_formats'] = $theme_advanced_fonts;
    return $init;
}
add_filter( 'tiny_mce_before_init', 'mce_custom_fonts' );


// tiny mce custom font sizes
if ( ! function_exists( 'wpex_mce_text_sizes' ) ) {
    function wpex_mce_text_sizes( $init_array ) {
        $init_array['fontsize_formats'] = "12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 32px 36px 40px 72px 80px";
        return $init_array;
    }
    add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );
}


// user data
// get userdata and convert it into associative array
$myusers = get_users();
$userArr = [];

foreach ($myusers as $user) {
	$userArr[] = [
		'id' => $user->ID,
		'email' => $user->user_login
	];
}

var_dump($userArr);

// get userdata by email 
$email = 'email@aemail.com';

if (is_email($email)) {

	$myusers = get_user_by( 'email', $email );
	$userArr = [];

	if ($myusers) {
		
		$user = $myusers->data;

		$userArr = [
			'id' => $user->ID,
			'username' => $user->user_login,
			'email' => $user->user_email
		];

		var_dump($userArr);

	} else {
		var_dump($userArr);
	}

} else {
	echo 'Invalid email';
}

// get user data by ID
 $user_info = get_userdata($id);

// adding user roles
// modifying restrictions
add_role(
    'service_center',
    'Service Center',
    array(
        'edit_posts' => true,
        'read' => true,
    )
);

// removing user role
remove_role( 'mis' ); 

//Remove Dashboard Metabox Widgets for all users except Admin
add_action('wp_dashboard_setup', 'stsd_remove_dashboard_widget' );

function stsd_remove_dashboard_widget() {
	if (!current_user_can('manage_options')) {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);    
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	}
} 

// RESTRICT MENU ITEMS
add_action('admin_menu', 'restrict_admin_menu');

function restrict_admin_menu() {

	$roles = array('mis', 'service_center', 'mis_staff');
	$user = wp_get_current_user();

	if( $user && isset($user->roles[0]) && in_array($user->roles[0], $roles) ) {
	    // remove_submenu_page('index.php', 'update-core.php'); //Dashboard->Updates
	    // remove_menu_page('index.php'); //Dashboard
	    remove_menu_page('edit.php'); //Posts
	    remove_menu_page('edit-comments.php'); // Comments
	    // remove_menu_page('plugins.php'); // Plugins
	    remove_menu_page('tools.php'); // Tools
	    remove_menu_page('edit.php?post_type=e-wallet'); // post type
	    remove_menu_page('edit.php?post_type=returns-list'); // post type
	}
}

// RESTRICT FUNCTIONALITIES
add_action('current_screen', 'restrict_current_screen');

function restrict_current_screen() {

	$screen = get_current_screen();
	$roles = array('mis', 'service_center', 'mis_staff');
	$user = wp_get_current_user();

	$restricted_pages = array(
		'edit-post',
		'post',
		'edit-category',
		'edit-post_tag',
		'edit-e-wallet',
		'edit-returns-list',
		'edit-comments',
		'tools',
	);

	if( $user && isset($user->roles[0]) && in_array($user->roles[0], $roles) ) {
		if (in_array($screen->id, $restricted_pages)) {
			wp_die(__("Sorry, you are not allowed to access this page."));
			exit;
		}
	}
}


// runs a function when post changed in status
function wp_post_changed_status( $new_status, $old_status, $post ) {
    if ( ( 'draft' === $new_status && 'publish' === $old_status ) && 'returns-list' === $post->post_type) {
    		$uc_id = 98;
            update_field('field_5c12f5830de6a', '8888', 'user_'.$uc_id);
    }
}
add_action( 'transition_post_status', 'wp_post_changed_status', 10, 3 );


// get users
$args = array(
	'blog_id'      => $GLOBALS['blog_id'],
	'role'         => '',
	'role__in'     => array(),
	'role__not_in' => array(),
	'meta_key'     => '',
	'meta_value'   => '',
	'meta_compare' => '',
	'meta_query'   => array(),
	'date_query'   => array(),        
	'include'      => array(),
	'exclude'      => array(),
	'orderby'      => 'login',
	'order'        => 'ASC',
	'offset'       => '',
	'search'       => '',
	'number'       => '',
	'count_total'  => false,
	'fields'       => 'all',
	'who'          => '',
 ); 

get_users( $args ); 


// get users with relational meta key
$get_users = get_users( 
	array(
		// 'role' => 'partner',
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key' => 'referral_code',
				'value' => udata('referral_code') ,
				'compare' => '=',
				),
			array(
				'key' => 'previous_partner_referral_code',
				'value' => udata('referral_code') ,
				'compare' => '=',
				)
			),

        // 'meta_key' => 'referral_code',
        // 'meta_value' => $partner_referral_code,
		'exclude' => array( udata('id')  )
	)
);


// get all current logged in user's data
function udata($data=''){

	$user_data = wp_get_current_user();

	$u_id = $user_data->ID;

	// Default
	// $fullname = $user_data->user_firstname.' '.$user_data->user_lastname;
	$email = $user_data->user_email;

	$user_meta = get_userdata($u_id);
	$role = $user_meta->roles[0];

	// Woo
	$billing_fname = get_user_meta( $u_id, 'billing_first_name', true ); 
	$billing_lname = get_user_meta( $u_id, 'billing_last_name', true ); 
	$billing_add_1 = get_user_meta( $u_id, 'billing_address_1', true ); 
	$billing_add_2 = get_user_meta( $u_id, 'billing_address_2', true ); 
	$billing_phone = get_user_meta( $u_id, 'billing_phone', true );
	// $billing_email = get_user_meta( $u_id, 'billing_email', true );

	// ACF
	$no_image = get_template_directory_uri().'/assets/images/no-image.jpg';
	$profile = (get_field('user_profile', 'user_'.$u_id)) ? get_field('user_profile', 'user_'.$u_id) : $no_image ;                                                 
	$fullname = get_field('user_fullname','user_'.$u_id);
	$age = get_field('user_age','user_'.$u_id);
	$gender = get_field('user_gender','user_'.$u_id);
	$partner_referral_code = (get_field('referral_code','user_'.$u_id)) ? get_field('referral_code','user_'.$u_id) : '' ;
	$previous_referral_code = (get_field('previous_partner_referral_code','user_'.$u_id)) ? get_field('previous_partner_referral_code','user_'.$u_id) : '' ;

	$isPromoted = (get_field('promoted_to_partner','user_'.$u_id)) ? true : false ; //determine if user has promoted to partner


	// Total Commissions
	$total_earnings = (get_field('total_earnings','user_'.$u_id)) ? get_field('total_earnings','user_'.$u_id) : 0 ;
	$commission_to_partner = (get_field('commission_to_partner','user_'.$u_id)) ? get_field('commission_to_partner','user_'.$u_id) : 0 ;
	$commission_to_previous_partner = (get_field('commission_to_previous_partner','user_'.$u_id)) ? get_field('commission_to_previous_partner','user_'.$u_id) : 0 ;

	$user_details = array(
		//Default
		'id' => $u_id,
		'email' => $email,
		'role' => $role,

		//Woocommerce
		'billing' => array(
			'fname' => $billing_fname,
			'lname' => $billing_lname,
			'add1' => $billing_add_1,
			'add2' => $billing_add_2,
			'phone' => $billing_phone,
		),

		//ACF
		'image' => $profile,
		'fullname' => $fullname,
		'age' => $age,
		'gender' => $gender,
		'referral_code' => $partner_referral_code,
		'prev_referral_code' => $previous_referral_code,
		'is_promoted' => $isPromoted,

		//commissions
		'total_earnings' => $total_earnings,
		'com_to_partner' => $commission_to_partner,
		'com_to_prev_partner' => $commission_to_previous_partner,

		// Others
		'name' => ($fullname) ? $fullname : $billing_fname.' '.$billing_lname,
		'no_image' => $no_image
	);

	return $user_details[$data];
}


// get post data by title
$args = array(
	"post_type" => "e-wallet", 
	"s" => $title
);

$query = get_posts( $args );
var_dump($query[0]->ID);


// sorting multi-dimensional array
// sorting via specific key
$users_partner = get_users(
	array(
		'role' => 'partner',
		'meta_key'=> 'total_earnings_customer',
		'orderby' => 'meta_value_num',
		'order'   => 'ASC',
		'exclude' => array( udata('id') )
	)
);

$x = 0;
$users_partner_array = [];
$user_partner_array = [];

foreach ($users_partner as $user_partner) {

	$uid = $user_partner->ID;

	$commisions = get_field('field_5bfe5f73304bb','user_'.$uid);

	var_dump($commisions);

	$total = 0;

	foreach ($commisions as $commision) {
		$com = $commision['customer_commission'];
		$total = $total + $com;
	}

	$user_partner_array['id'] = $uid;
	$user_partner_array['total'] = $total;

	$users_partner_array[$x] = $user_partner_array;

	var_dump($total);

	$x++;
}


var_dump($users_partner_array);

function cmp($a, $b) {
	return strcmp($a['total'], $b['total']);
}

usort($users_partner_array, "cmp");

foreach ($users_partner_array as $user_partner_array) {
	echo $user_partner_array['total'].'<br>';
}

var_dump($users_partner_array);


// count values in multi-dimensional array
$counts = array();

foreach ($prods_array as $key=>$subarr) {

	if (isset($counts[$subarr['catid']])) {
		$counts[$subarr['catid']]++;
	} else {
		$counts[$subarr['catid']] = 1;
	}

	$counts[$subarr['catid']] = isset($counts[$subarr['catid']]) ? $counts[$subarr['catid']]++ : 1;
}


// formatting decimal value
₱ echo wc_format_decimal( $item->get_total(), 2);


// date range
$res = [];
$dates = [];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$id = 35;
$comm = get_field( 'field_5bfe5f73304bb', 'user_'.udata('id'));
$x = 0;

$start_date =  DateTime::createFromFormat('Y-m-d', $start_date);
$end_date =  DateTime::createFromFormat('Y-m-d', $end_date);

$start_date = $start_date->format('Y-m-d');
$end_date = $end_date->format('Y-m-d');

$start_date =  strtotime($start_date);
$end_date =  strtotime($end_date);

$res['start_date'] = $start_date;
$res['end_date'] = $end_date;

foreach ($comm as $date) {
	$coomDate = $date['customer_date_purchasedx'];
	$commDate =  DateTime::createFromFormat('d/m/Y', $coomDate);
	$commDate = $commDate->format('Y-m-d');
	$commDate =  strtotime($commDate);

	if (($commDate >= $start_date) && ($commDate <= $end_date)) {
		$dates[$x] = $commDate;
	}

	$x++;
}





























?>