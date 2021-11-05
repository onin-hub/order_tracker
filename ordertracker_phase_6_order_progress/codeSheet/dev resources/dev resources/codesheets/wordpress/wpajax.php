<!-- 
==================================================
	initialization.php / function.php
================================================== 
-->

<!-- initialize wp ajax and it's functions -->
<?php 

if (!function_exists('global_js_var')) {

    add_action('wp_head','global_js_var');

    function global_js_var() {
	    ?>
	        <script>
	        	// js global variables
	            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	            var themeurl = '<?php echo get_template_directory_uri(); ?>';
	        </script>
	    <?php
    }
}

?>


<!-- 
==================================================
	script.js
================================================== 
-->

<!-- create ajax call -->
<script type="text/javascript">

jQuery(function($) {

	$('button').on('click', function(e) {

		var id = e;
		var data = {
			'action' : 'action_name1', //php function to be called in ajax.php
			"id" : id // data/value to be passed in ajax.php
		};

		$.ajax({
			url : ajaxurl,
			type : "POST",
			datatype : 'json/html',
			data : data,
			success : function(response) {
				// convert the json response into object
				var obj = $.parseJSON(response);
				console.log(obj);
			},
			error : function() {
				alert("Something went wrong!");
			}
		});

	});

});

</script>


<!-- 
==================================================
	ajax.php
================================================== 
-->

<!-- create ajax file -->
<!-- this is where you will get the response to the request of ajax call -->
<!-- create action functions -->
<?php

function action_name1() {
	$id = null;

	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	}

	// get posts by id
	$args = array(
		'post_type' => 'program',
		'post__in' => array($id)
	);

	$posts = get_posts($args);
	$posts = json_encode($posts);

	// send json response to the request
	wp_send_json($posts);

	die();
}
add_action('wp_ajax_action_name1', 'action_name1');
add_action('wp_ajax_nopriv_action_name1', 'action_name1');

?>


<!-- 
==================================================
	function.php
================================================== 
-->

<!-- include ajax file into the wordpress function.php -->
<?php include_once( 'inc/ajax.php' ); ?>