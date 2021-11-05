<!-- put this below opening body tag -->
<script type="text/javascript">
	var logo_url = "<?php echo get_header_image(); ?>";
</script>


<!-- wrapped the header div-->
<div id="mypage">

<!-- put this end tag below get_footer(); function -->
</div>


<!-- HEADER -->
<div id="header">
	<div>
		<?php $logo = get_field('homepage_logo', 'option'); ?>
		<a href="<?php bloginfo('url'); ?>/"> 
			<img src="<?php echo $logo; ?>" class="img-responsive" alt="logo"> 
		</a>
	</div>

	<div class="full-nav-wrapper">
		<div class="p-menu-nav-wrapper">
			<?php wp_nav_menu(array(
				"menu" => "Main Menu",
				'menu_class' => 'menu-list-container'
			)); ?>
		</div>	

		<div class="p-search-wrapper">
			<i id="p-search-btn" class="fa fa-search" aria-hidden="true"></i>
			<div id="p-search-input">
				<?php get_search_form(); ?>
			</div>
		</div>

		<div id="mywrapper" class="hidden d-none">       
			<nav id="mymenu" class="my-menu">
				<?php
					$menu_mobile = array(
						'theme_location' => 'mobile'
						);
					wp_nav_menu( $menu_mobile );
				?>
			</nav>
		</div>  
	</div>

	<div class="p-burger-menu">
		<a href="#mymenu" class="menuicon"><i class="fa fa-bars"></i></a>
	</div>
</div>

<!-- setup js script -->
<script type="text/javascript">
	$(".my-menu").mmenu({
		"extensions": [
			"pagedim-black",
			"position-right"
		],

		navbars: [{
			content: [ "<img src='"+logo_url+"' class='img-fluidz'/>" ],
			height: 2
		}],

		offCanvas: {
			position  : "center",
			zposition : "front"
		}, 

		navbar: {
            // title: site_name
        }
     });

	var API = $(".my-menu").data( "mmenu" );

	$( window ).resize(function() {
		API.close();
	});
</script>