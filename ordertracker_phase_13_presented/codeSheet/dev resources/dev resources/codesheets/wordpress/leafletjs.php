<!-- 
==================================================
	map.php	
================================================== 
-->

<!-- displaying the map in map.php page -->


<?php 
    
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

// loop through program post type
$args = array(
	'post_type' => 'program'
);

$post_query = new WP_Query($args);

if($post_query->have_posts() ) {

	$programs = [];

	while($post_query->have_posts() ) {
		$post_query->the_post();

		$data = [];

		// get coordinate acf field
		$coord = get_field('field_5bfcde5d23b7d');

		if ($coord) {
			$data['id'] = get_the_ID();
			$data['title'] = get_the_title();
			$data['loc'] = $coord;
			$programs[] = $data;
		}
	}

	$programs = json_encode($programs);
}

?>

<div>
    <div id="mapss" style="width: 100%; height: 400px"></div>

    <script>

    var locations = <?php echo json_encode($programs); ?>;
    var obj = JSON.parse(locations);
    var map = L.map('mapss').setView([12.8797, 121.7740], 5);

    mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';

    L.tileLayer(
       	'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; ' + mapLink + ' Contributors',
        maxZoom: 18,
    }).addTo(map);

    // Add a place to save markers
	var markers = {};

    for (var i = 0; i < obj.length; i++) {

    	var lat = parseFloat(obj[i]['loc'][0]['latitude']);
    	var long = parseFloat(obj[i]['loc'][0]['longitude']);
     	var program = obj[i];
  
		// Create and save a reference to each marker
		markers[program.id] = L.marker([lat,long], {
			title: program.title,
			riseOnHover: true
		}).addTo(map);
	  
		// Add the ID
		markers[program.id]._icon.id = program.id;
    }
     
    </script>
</div>

<?php get_footer(); ?>


<!-- 
==================================================
	script.js	
================================================== 
-->

<!-- calling the ajax request for marker on click -->
<script>

$('.leaflet-marker-icon').on('click', function(e) {
   // Use the event to find the clicked element
   var el = $(e.srcElement || e.target);
   var id = el.attr('id');
   
	// var data = {"id" : id};

	$.ajax({
		url : ajaxurl,
		type : "POST",
		datatype : 'json/html',
		data : {
			'action' : 'action_name1', //php function to be called in ajax.php
			'id' : id, // data/value to be passed in ajax.php
		},
		success : function(response) {
			$('body').append(response);
			$('#details-modal').modal('toggle');
		},
		error : function() {
			alert("Something went wrong!");
		}
  	});

});
</script>


<!-- 
==================================================
	modal.php
================================================== 
-->

<!-- toggling the details modal -->

<?php
function action_name1() {

	$id = $_POST['id'];

	$args = array(
		'post_type' => 'program',
		'post__in' => array($id)
		);

	$posts = get_posts($args);
	?>

	
	<!-- insert modal code here -->

	<?php

	die();
}
add_action('wp_ajax_action_name1', 'action_name1');
add_action('wp_ajax_nopriv_action_name1', 'action_name1');
