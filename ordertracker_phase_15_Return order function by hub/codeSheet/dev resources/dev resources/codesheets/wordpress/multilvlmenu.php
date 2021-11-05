<?php 
// register the menu
if ( ! function_exists( 'add_menus' ) ) {
	function add_menus() {
		// Menu locations set in backend
		register_nav_menus( array(
			'main_menu'   => __( 'Main Menu', 'template_name' ),
			'mobile' => __( 'Mobile Menu', 'template_name' ),

			//'supporting_menu' => __( 'Additional Menu', 'template_name' ),
		) );
	}
	add_action( 'after_setup_theme', 'add_menus' );
}
?>


<!-- invoke menu at header.php -->
<div class="full-nav-wrapper">
	<div class="p-menu-nav-wrapper">
		<?php wp_nav_menu(array(
			"menu" => "Main Menu",
			'menu_class' => 'menu-list-container'
		)); ?>
	</div>	
</div>


<!-- styling multi level menu -->
<style type="text/css">
	ul#menu-main-menu li a {
	    padding: 27px 10px;
	}

	ul#menu-main-menu li.current_page_item a,
	ul#menu-main-menu li a:hover {
	    border-bottom: 4px solid #ef3d3a;
	}

	ul#menu-main-menu li ul.sub-menu a {
	    border-bottom: none;
	    padding: 0;
	}

	/*multi dropdown menu*/
	ul#menu-main-menu {
	    background: #fff;
	    position: relative;
	    z-index: 9999;
	}

	ul#menu-main-menu a {
	    color: #000;
	    text-decoration: none;
	    text-transform: uppercase;
	    font-size: 14px;
	    font-weight: 500;
	}

	ul#menu-main-menu ul {
	    background: #fff;
	    float: left;
	}

	ul#menu-main-menu li {
	    float: left;
	    display: inline;
	    position: relative;
	    list-style: none;
	    cursor: pointer;
	    display: inline-block;
	    padding-right: 0;
	    text-align: left;
	    padding: 0 10px;
	}

	ul#menu-main-menu ul {
	    position: absolute;
	    left: 11px;
	    top: 54px;
	    background: #fff;
	    width: 100%;
	    display: none;
	}

	ul#menu-main-menu ul ul {
	    left: 100%;
	    top: 0;
	    background: #fff;
	}

	ul#menu-main-menu li:hover > ul {
	    display: block;
	}

	ul#menu-main-menu ul {
	    list-style: none;
	    padding: 0;
	}

	ul#menu-main-menu ul ul {
	    top: -8px;
	}

	ul#menu-main-menu li ul.sub-menu li {
	    padding: 9px 9px;
	    background: #fff;
	    width: 100%;
	    border-bottom: 1px solid #fef0f0;
	}

	ul#menu-main-menu li ul.sub-menu li:hover {
	    background: #fef0f0;
	}

	ul.sub-menu {
	    width: 200px !important;
	}
</style>